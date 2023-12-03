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

    private const string EMPTY_VALUE = '.';

    public function __construct(
        public Coordinate $coordinate,
        public string $value
    ) {
    }

    public static function from(int $x, int $y, string $value): self
    {
        return new self(new Coordinate($x, $y), $value);
    }

    public static function emptyOn(Coordinate $coordinate): self
    {
        return new self($coordinate, self::EMPTY_VALUE);
    }

    public function coordinateAsString(): string
    {
        return $this->coordinate->asString();
    }

    public function isSymbol(): bool
    {
        $symbols   = self::NUMBERS;
        $symbols[] = self::EMPTY_VALUE;

        return !in_array($this->value, $symbols, true);
    }

    public function hasNumberValue(): bool
    {
        return in_array($this->value, self::NUMBERS, true);
    }

    /** @return Coordinate[] */
    public function adjacentCoordinates(): array
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

    public function nextCoordinateToRight(): Coordinate
    {
        return $this->coordinate->nextToRight();
    }

    public function isEmpty(): bool
    {
        return $this->value === self::EMPTY_VALUE;
    }
}
