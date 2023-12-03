<?php

namespace Advent\N3;

readonly class Coordinate
{

    public function __construct(
        public int $x,
        public int $y,
    ) {
    }

    public static function fromText(string $textCoordinate): self
    {
        [$x, $y] = explode('.', $textCoordinate);

        if ($x === null || $y === null) {
            throw new \RuntimeException(
                sprintf(
                    'Wrong coordinate values: x => %s y => %s',
                    $x ?? 'null',
                    $y ?? 'null',
                )
            );
        }

        return new self((int)$x, (int)$y);
    }

    public function asString(): string
    {
        return sprintf('%s.%s', $this->x, $this->y);
    }
}
