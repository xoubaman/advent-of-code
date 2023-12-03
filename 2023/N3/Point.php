<?php

namespace Advent\N3;

readonly class Point
{
    private const array NUMBERS = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
    ];

    private const string EMPTY_SPACE = '.';

    public function __construct(
        public Coordinate $coordinate,
        public string $value
    ) {
    }

    public function coordinateAsString(): string
    {
        return $this->coordinate->asString();
    }

    public function isSymbol(): bool
    {
        $symbols   = self::NUMBERS;
        $symbols[] = self::EMPTY_SPACE;

        return !in_array($this->value, $symbols, true);
    }

    public function hasNumberValue(): bool
    {
        return in_array($this->value, self::NUMBERS, true);
    }

    /** @return Coordinate[] */
    public function getAdjacentCoordinates(): array
    {
        $x = $this->coordinate->x;
        $y = $this->coordinate->y;

        $values = [
            [$x - 1, $y - 1],
            [$x, $y - 1],
            [$x + 1, $y - 1],
            [$x - 1, $y],
            [$x + 1, $y],
            [$x - 1, $y + 1],
            [$x, $y + 1],
            [$x + 1, $y + 1],
        ];

        return array_map(static fn(array $v) => new Coordinate($v[0], $v[1]), $values);
    }

    public function coordinateToTheRight(): Coordinate
    {
        return $this->coordinate->nextToRight();
    }
}
