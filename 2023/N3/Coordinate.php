<?php

namespace Advent\N3;

readonly class Coordinate
{

    public function __construct(
        public int $x,
        public int $y,
    ) {
    }
}
