<?php

namespace Advent\N3;

use PHPUnit\Framework\TestCase;

class Three extends TestCase
{
    const true  USE_REAL_INPUT    = true;
    const false USE_EXAMPLE_INPUT = false;

    public function testFirstPart(): void
    {
        $input = explode("\n", $this->getInput(self::USE_EXAMPLE_INPUT));

        $grid = Grid::fromArray($input);

        $result = $grid->calculateSum();

        self::assertEquals(4361, $result);
    }

    public function testGridFromArray(): void
    {
        $input = [
            '46',
            '..',
        ];

        $grid = Grid::fromArray($input);

        $expected = new Grid(
            new Point(new Coordinate(0, 0), '4'),
            new Point(new Coordinate(1, 0), '6'),
            new Point(new Coordinate(0, 1), '.'),
            new Point(new Coordinate(1, 1), '.'),
        );

        self::assertEquals($expected, $grid);
    }

    private function getInput(bool $realInput): string
    {
        if (!$realInput) {
            file_get_contents('input-test.txt');
        }

        return file_get_contents('input.txt');
    }
}
