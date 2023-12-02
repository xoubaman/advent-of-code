<?php

use Advent\N2\Game;
use PHPUnit\Framework\TestCase;

class Two extends TestCase
{
    const true  USE_REAL_INPUT    = true;
    const false USE_EXAMPLE_INPUT = false;

    public function testFirstPart(): void
    {
        $input = $this->getInput(self::USE_REAL_INPUT);
        $grouped = $this->groupInput($input);

        $cubes = [
            'red' => 12,
            'green' => 13,
            'blue' => 14,
        ];

        $result = $this->calculateFirstPart($cubes, $grouped);

        self::assertEquals(2348, $result);
    }

    public function testSecondPart(): void
    {
        $input   = $this->getInput(self::USE_REAL_INPUT);
        $grouped = $this->groupInput($input);

        $result = $this->calculateSecondPart($grouped);

        self::assertEquals(76008, $result);
    }

    /**
     * @param array<string,int> $cubes
     * @param array<Game> $grouped
     */
    public function calculateFirstPart(array $cubes, array $grouped): int
    {
        $result = 0;
        foreach ($grouped as $game) {
            if ($game->canBePlayedWith($cubes)) {
                $result += $game->id;
            }
        }

        return $result;
    }

    /**
     * @param array<Game> $grouped
     */
    public function calculateSecondPart(array $grouped): int
    {
        $totalPower = 0;
        foreach ($grouped as $game) {
            $totalPower += $game->power();
        }

        return $totalPower;
    }

    public function groupInput(string $input): array
    {
        $grouped = [];
        foreach (explode("\n", $input) as $line) {
            $game = Game::fromLine($line);
            $grouped[] = $game;
        }

        return $grouped;
    }

    private function getInput(bool $real): string
    {
        if (!$real) {
            return 'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green';
        }

        return file_get_contents('input.txt');
    }

}
