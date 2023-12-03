<?php

namespace Advent\N3;

readonly class Point
{

    public function __construct(
        public Coordinate $coordinate,
        public string $value
    ) {
    }
}
