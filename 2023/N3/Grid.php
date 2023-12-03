<?php

namespace Advent\N3;

readonly class Grid
{
    private int $maxX;
    private int $maxY;
    /** @var Point[] */
    private array $points;

    /**
     * @param array<Point> $points
     */
    public function __construct(int $maxX, int $maxY, Point ...$points)
    {
        $indexedPoints = [];
        foreach ($points as $point) {
            $indexedPoints[$point->coordinateAsString()] = $point;
        }
        $this->maxX   = $maxX;
        $this->maxY   = $maxY;
        $this->points = $indexedPoints;
    }

    public static function fromArray(array $input): self
    {
        $points = [];
        $y      = 0;
        foreach ($input as $line) {
            $x = 0;
            foreach (str_split($line) as $value) {
                $point = new Point(new Coordinate($x, $y), $value);
                $x++;
                if ($point->isEmpty()) {
                    continue;
                }
                $points[] = $point;
            }

            $y++;
        }

        return new self(strlen($line) - 1, $y - 1, ...$points);
    }

    public function isOutbounds(Point $point): bool
    {
        return $point->coordinate->x < 0
            || $point->coordinate->x > $this->maxX
            || $point->coordinate->y < 0
            || $point->coordinate->y > $this->maxY;
    }

    /** @return array<Point> */
    public function adjacentOf(Coordinate $coordinate): array
    {
        $point = $this->pointInCoordinate($coordinate);

        $adjacentCoordinates = $point->adjacentCoordinates();

        $points = array_map(
            fn(Coordinate $coordinate) => $this->pointInCoordinate($coordinate),
            $adjacentCoordinates
        );

        return array_filter(
            $points,
            fn(Point $p) => !$this->isOutbounds($p)
        );
    }

    private function pointInCoordinate(Coordinate $coordinate): Point
    {
        return $this->points[$coordinate->asString()] ?? Point::emptyOn($coordinate);
    }

    /** @return array<Point> */
    public function allSymbols(): array
    {
        return array_filter($this->points, static fn(Point $p) => $p->isSymbol());
    }

    /** @return RangeOfNumericPoints[] */
    public function allNumbers(): array
    {
        $numbers       = [];
        $checkedPoints = [];

        foreach ($this->points as $point) {
            if (in_array($point->coordinateAsString(), $checkedPoints, true)) {
                continue;
            }

            if (!$point->hasNumberValue()) {
                continue;
            }

            $numberPoints = $this->numberPointsStartingAt($point);

            $checkedPoints = array_merge($checkedPoints, array_keys($numberPoints));

            $numbers[] = new RangeOfNumericPoints(...$numberPoints);
        }

        return $numbers;
    }

    public function calculateSum(): int
    {
        $sum = 0;
        foreach ($this->allNumbers() as $number) {
            foreach ($number->adjacentCoordinates() as $adjacent) {
                $point = $this->pointInCoordinate($adjacent);
                if ($point->isSymbol()) {
                    $sum += $number->value();
                    break;
                }
            }
        }

        return $sum;
    }

    public function calculateGearRatio(): int
    {
//        $gears = $this->allSymbols();
    }

    /** @return Point[] */
    private function numberPointsStartingAt(Point $point): array
    {
        if (!$point->hasNumberValue()) {
            return [];
        }

        $points = [];

        do {
            $points[$point->coordinateAsString()] = $point;
            $point = $this->pointInCoordinate($point->nextCoordinateToRight());
        } while ($point->hasNumberValue());

        return $points;
    }
}
