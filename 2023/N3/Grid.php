<?php

namespace Advent\N3;

class Grid
{
    /** @var Point[] */
    private array $points;

    /**
     * @param array<Point> $points
     */
    public function __construct(Point ...$points)
    {
        foreach ($points as $point) {
            $this->points[$point->coordinateAsString()] = $point;
        }
    }

    public static function fromArray(array $input): self
    {
        $points = [];
        $y      = 0;
        foreach ($input as $line) {
            $x = 0;
            foreach (str_split($line) as $value) {
                $points[] = new Point(new Coordinate($x, $y), $value);
                $x++;
            }

            $y++;
        }

        return new self(...$points);
    }

    /** @return array<Point> */
    public function adjacentOfTextCoordinate(string $textCoordinate): array
    {
        return $this->adjacentOf(Coordinate::fromText($textCoordinate));
    }

    /** @return array<Point> */
    public function adjacentOf(Coordinate $coordinate): array
    {
        $point = $this->pointInCoordinate($coordinate);

        if (!$point) {
            return [];
        }

        $adjacentCoordinates = $point->getAdjacentCoordinates();

        return array_filter(
            array_map(
                fn(Coordinate $coordinate) => $this->pointInCoordinate($coordinate),
                $adjacentCoordinates
            )
        );
    }

    private function pointInCoordinate(Coordinate $coordinate): null|Point
    {
        return $this->points[$coordinate->asString()] ?? null;
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
                if ($point && $point->isSymbol()) {
                    $sum += $number->value();
                    break;
                }
            }
        }

        return $sum;
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
            $point                                = $this->pointInCoordinate($point->coordinateToTheRight());
        } while ($point !== null && $point->hasNumberValue());

        return $points;
    }
}
