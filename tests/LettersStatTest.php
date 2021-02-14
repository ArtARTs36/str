<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Support\LettersStat;
use PHPUnit\Framework\TestCase;

class LettersStatTest extends TestCase
{
    /**
     * @covers \ArtARTs36\Str\Support\LettersStat::inputs
     */
    public function testInputs(): void
    {
        $stat = new LettersStat([
            'A' => 1,
            'B' => 2,
        ]);

        self::assertEquals(1, $stat->inputs('A'));
        self::assertEquals(2, $stat->inputs('B'));
        self::assertEquals(0, $stat->inputs('C'));
    }

    /**
     * @covers \ArtARTs36\Str\Support\LettersStat::getLetterByMaxInputs
     */
    public function testGetLetterByMaxInputs(): void
    {
        $stat = new LettersStat([
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
        ]);

        self::assertEquals('D', $stat->getLetterByMaxInputs());
    }

    /**
     * @covers \ArtARTs36\Str\Support\LettersStat::getMaxInputs
     */
    public function testGetMaxInputs(): void
    {
        $stat = new LettersStat([
            'A' => 1,
            'B' => 2,
            'C' => 3,
        ]);

        self::assertEquals(3, $stat->getMaxInputs());
    }
}
