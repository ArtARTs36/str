<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Tab;
use PHPUnit\Framework\TestCase;

class TabTest extends TestCase
{
    public function providerForTestAddSpaces(): array
    {
        return [
            [
                [
                    'A',
                    'A1',
                    'A123',
                    'A1234',
                    'A12345',
                    'A123456',
                ],
                [
                    'A       ',
                    'A1      ',
                    'A123    ',
                    'A1234   ',
                    'A12345  ',
                    'A123456 ',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestAddSpaces
     */
    public function testAddSpaces(array $input, array $expected): void
    {
        self::assertEquals($expected, Tab::addSpaces($input));
    }
}
