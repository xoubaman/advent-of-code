<?php

namespace Advent\N3;

use PHPUnit\Framework\TestCase;

class Three extends TestCase
{
    const true  USE_REAL_INPUT    = true;
    const false USE_EXAMPLE_INPUT = false;

    public function testFirstPart(): void
    {
        $input = explode("\n", $this->getInput(self::USE_REAL_INPUT));

        $grid = Grid::fromArray($input);

        $result = $grid->calculateSum();

        self::assertEquals(535078, $result);
    }

    public function testSecondPart(): void
    {
        $input = explode("\n", $this->getInput(self::USE_EXAMPLE_INPUT));

        $grid = Grid::fromArray($input);

        $result = $grid->calculateGearRatio();

        self::assertEquals(467835, $result);
    }

    public function testGridFromArray(): void
    {
        $input = [
            '46.',
            '.a.',
            '..f',
        ];

        $grid = Grid::fromArray($input);

        $expected = new Grid(
            2,
            2,
            Point::from(0, 0, '4'),
            Point::from(1, 0, '6'),
            Point::from(1, 1, 'a'),
            Point::from(2, 2, 'f'),
        );

        self::assertEquals($expected, $grid);
    }

    public function testGridBoundaries(): void
    {
        $input = [
            '46*',
            '..a',
            'ze#',
        ];

        $grid = Grid::fromArray($input);

        self::assertTrue($grid->isOutbounds(Point::from(-1, 0, '.')));
        self::assertTrue($grid->isOutbounds(Point::from(3, 0, '.')));
        self::assertTrue($grid->isOutbounds(Point::from(0, -1, '.')));
        self::assertTrue($grid->isOutbounds(Point::from(0, 31, '.')));

        self::assertfalse($grid->isOutbounds(Point::from(0, 0, '.')));
        self::assertfalse($grid->isOutbounds(Point::from(2, 0, '.')));
        self::assertfalse($grid->isOutbounds(Point::from(2, 2, '.')));
        self::assertfalse($grid->isOutbounds(Point::from(0, 2, '.')));
        self::assertfalse($grid->isOutbounds(Point::from(1, 1, '.')));
    }

    public function testFindAdjacentOfAPoint(): void
    {
        $input = [
            '46*',
            '..a',
            'ze#',
        ];

        $grid = Grid::fromArray($input);

        $adjacent1 = $grid->adjacentOf(Coordinate::fromText('0.0'));

        self::assertEquals(
            [
                Point::from(1, 0, '6'),
                Point::from(0, 1, '.'),
                Point::from(1, 1, '.'),
            ],
            array_values($adjacent1)
        );

        $adjacent2 = $grid->adjacentOf(Coordinate::fromText('1.1'));

        self::assertEquals(
            [
                Point::from(0, 0, '4'),
                Point::from(1, 0, '6'),
                Point::from(2, 0, '*'),

                Point::from(0, 1, '.'),
                Point::from(2, 1, 'a'),

                Point::from(0, 2, 'z'),
                Point::from(1, 2, 'e'),
                Point::from(2, 2, '#'),
            ],
            array_values($adjacent2)
        );
    }

    public function testFindAllSymbolsInGrid(): void
    {
        $input = [
            '46*',
            '..a',
            'ze#',
        ];

        $grid = Grid::fromArray($input);

        $allSymbols = $grid->allSymbols();

        $expected = [
            Point::from(2, 0, '*'),
            Point::from(2, 1, 'a'),
            Point::from(0, 2, 'z'),
            Point::from(1, 2, 'e'),
            Point::from(2, 2, '#'),
        ];

        self::assertEquals($expected, array_values($allSymbols));
    }

    public function testFindAllNumbersInGrid(): void
    {
        $input = [
            '4*12',
            '..a8',
            'r055',
        ];

        $grid = Grid::fromArray($input);

        $allSymbols = $grid->allNumbers();

        $expected = [
            new RangeOfNumericPoints(
                Point::from(0, 0, '4'),
            ),
            new RangeOfNumericPoints(
                Point::from(2, 0, '1'),
                Point::from(3, 0, '2'),
            ),
            new RangeOfNumericPoints(
                Point::from(3, 1, '8'),
            ),
            new RangeOfNumericPoints(
                Point::from(1, 2, '0'),
                Point::from(2, 2, '5'),
                Point::from(3, 2, '5'),
            ),
        ];

        self::assertEquals($expected, array_values($allSymbols));
    }

    private function getInput(bool $realInput): string
    {
        if (!$realInput) {
            return file_get_contents('input-test.txt');
        }

        return file_get_contents('input.txt');
    }
}
