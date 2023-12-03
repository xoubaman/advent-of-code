<?php

namespace Advent\N3;

class RangeOfNumericPoints
{
    /** @var array<Point> */
    private array $points;

    public function __construct(
        Point ...$points
    ) {
        $this->points = array_values($points);
    }

    public function value(): int
    {
        return (int)array_reduce(
            $this->points,
            static fn(string $carry, Point $point) => $carry . $point->value,
            ''
        );
    }

    /** @return Coordinate[] */
    public function adjacentCoordinates(): array
    {
        $adjacent = [];
        foreach ($this->points as $point) {
            foreach ($point->getAdjacentCoordinates() as $coordinate) {
                $adjacent[$coordinate->asString()] = $coordinate;
            }
        }

        return $adjacent;
    }
}
