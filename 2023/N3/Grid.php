<?php

namespace Advent\N3;

class Grid
{
    /** @var array<Point> */
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
        $point = $this->findPointInCoordinate($coordinate);

        if (!$point) {
            return [];
        }

        $adjacentCoordinates = $point->getAdjacentCoordinates();

        return array_filter(
            array_map(
                fn(Coordinate $coordinate) => $this->findPointInCoordinate($coordinate),
                $adjacentCoordinates
            )
        );
    }


    private function findPointInCoordinate(Coordinate $coordinate): null|Point
    {
        return $this->points[$coordinate->asString()] ?? null;
    }

    /** @return array<Point> */
    public function findAllSymbols(): array
    {
        return array_filter($this->points, static fn(Point $p) => $p->isSymbol());
    }

    public function calculateSum(): int
    {
        $allSymbolPoints = array_filter($this->points, static fn(Point $p) => $p->isSymbol());

        foreach ($allSymbolPoints as $point) {
        }
    }
}
