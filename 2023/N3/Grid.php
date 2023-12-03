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
        $this->points = $points;
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
}
