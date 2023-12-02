<?php

namespace Advent\N2;

readonly class Game
{
    public int $id;

    public array $sets;

    public function __construct(int $id, array $sets)
    {
        $this->id   = $id;
        $this->sets = $sets;
    }

    public static function fromLine(string $line): self
    {
        $split = explode(':', str_replace(';', ',', $line));
        $id    = (int)str_replace('Game ', '', $split[0]);

        $sets = [];
        foreach (explode(',', $split[1]) as $draw) {
            [$quantity, $color] = explode(' ', trim($draw));

            $sets[] = [
                'quantity' => $quantity,
                'color'    => $color,
            ];
        }

        return new self($id, $sets);
    }

    public function canBePlayedWith(array $cubes): bool
    {
        foreach ($this->sets as $set) {
            $available = $cubes[$set['color']];
            if ($available < $set['quantity']) {
                return false;
            }
        }

        return true;
    }
}
