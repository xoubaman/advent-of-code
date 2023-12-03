<?php

namespace Advent\N3;

class Three extends TestCase
{
    const true  USE_REAL_INPUT    = true;
    const false USE_EXAMPLE_INPUT = false;

    public function testFirstPart(): void
    {
        $input = $this->getInput(self::USE_EXAMPLE_INPUT);

        $result = '';

        self::assertEquals(4361, $result);
    }

    private function getInput(bool $realInput): string
    {
        if (!$realInput) {
            file_get_contents('input-test.txt');
        }

        return file_get_contents('input.txt');
    }
}
