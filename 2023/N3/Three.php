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

    public function testFindAdjacentCoordinatesOfAPoint(): void
    {
        $input = [
            '46*',
            '..a',
            'ze#',
        ];

        $grid = Grid::fromArray($input);

        $adjacent1 = $grid->adjacentOfTextCoordinate('0.0');

        self::assertEquals(
            [
                new Point(new Coordinate(1, 0), '6'),
                new Point(new Coordinate(0, 1), '.'),
                new Point(new Coordinate(1, 1), '.'),
            ],
            array_values($adjacent1)
        );

        $adjacent2 = $grid->adjacentOfTextCoordinate('1.1');

        self::assertEquals(
            [
                new Point(new Coordinate(0, 0), '4'),
                new Point(new Coordinate(1, 0), '6'),
                new Point(new Coordinate(2, 0), '*'),

                new Point(new Coordinate(0, 1), '.'),
                new Point(new Coordinate(2, 1), 'a'),

                new Point(new Coordinate(0, 2), 'z'),
                new Point(new Coordinate(1, 2), 'e'),
                new Point(new Coordinate(2, 2), '#'),
            ],
            array_values($adjacent2)
        );
    }

    private function getInput(bool $realInput): string
    {
        if (!$realInput) {
            file_get_contents('input-test.txt');
        }

        return file_get_contents('input.txt');
    }
}
