<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    /**
     * @covers \ArtARTs36\Str\Str::make
     */
    public function testMake(): void
    {
        $string = Str::make('test');

        self::assertEquals('test', $string->__toString());
    }

    /**
     * @covers \ArtARTs36\Str\Str::count
     */
    public function testCount(): void
    {
        self::assertCount(4, Str::make('test'));
        self::assertCount(5, Str::make('Артем'));
    }

    /**
     * @covers \ArtARTs36\Str\Str::linesCount
     */
    public function testLinesCount(): void
    {
        self::assertEquals(1, Str::make('test')->linesCount());

        //

        $text = "Hello \n World \n Hello \n World";

        self::assertEquals(4, Str::make($text)->linesCount());
    }

    /**
     * @covers \ArtARTs36\Str\Str::lines
     */
    public function testLines(): void
    {
        $str = Str::make("Hello\nWorld\nHello\nWorld");

        $expected = [
            'Hello',
            'World',
            'Hello',
            'World',
        ];

        $response = $str->lines();

        foreach ($response as $i => $line) {
            self::assertInstanceOf(Str::class, $line);
            self::assertEquals($expected[$i], $line);
        }
    }

    /**
     * @covers \ArtARTs36\Str\Str::equals
     */
    public function testEquals(): void
    {
        self::assertTrue(Str::make('test')->equals('test'));
        self::assertFalse(Str::make('php')->equals('pHp'));
        self::assertTrue(Str::make('php')->equals('pHp', true));
    }

    /**
     * @covers \ArtARTs36\Str\Str::multiply
     */
    public function testMultiply(): void
    {
        $string = Str::make('test');

        self::assertEquals('test test test', $string->multiply(3, ' '));
    }

    /**
     * @covers \ArtARTs36\Str\Str::toStudlyCaps
     */
    public function testToStudlyCaps(): void
    {
        $string = Str::make('test test');

        self::assertEquals('TestTest', $string->toStudlyCaps());
    }

    /**
     * @covers \ArtARTs36\Str\Str::toCamelCase
     */
    public function testToCamelCase(): void
    {
        $string = Str::make('test test');

        self::assertEquals('testTest', $string->toCamelCase());
    }

    /**
     * @covers \ArtARTs36\Str\Str::isCamelCase
     */
    public function testIsCamelCase(): void
    {
        $string = Str::make('test test');

        self::assertFalse($string->isCamelCase());

        //

        $string = Str::make('testTest');

        self::assertTrue($string->isCamelCase());
    }

    /**
     * @covers \ArtARTs36\Str\Str::chars
     */
    public function testChars(): void
    {
        $string = Str::make('test');

        $chars = $string->chars();

        self::assertCount(4, $chars);
        self::assertEquals('t', $chars[0]);
        self::assertEquals('e', $chars[1]);
        self::assertEquals('s', $chars[2]);
        self::assertEquals('t', $chars[3]);

        //

        $string = Str::make('Водка');

        $chars = $string->chars();

        self::assertCount(5, $chars);
        self::assertEquals('В', $chars[0]);
        self::assertEquals('о', $chars[1]);
        self::assertEquals('д', $chars[2]);
        self::assertEquals('к', $chars[3]);
        self::assertEquals('а', $chars[4]);
    }

    /**
     * @covers \ArtARTs36\Str\Str::isStudlyCaps
     */
    public function testIsStudlyCaps(): void
    {
        $string = Str::make('artem');

        self::assertFalse($string->isStudlyCaps());

        //

        $string = Str::make('Artem');

        self::assertTrue($string->isStudlyCaps());
    }

    /**
     * @covers \ArtARTs36\Str\Str::toLower
     */
    public function testToLower(): void
    {
        $string = Str::make('TeSt');

        self::assertEquals('test', $string->toLower());
    }

    /**
     * @covers \ArtARTs36\Str\Str::toUpper
     */
    public function testToUpper(): void
    {
        $string = Str::make('TeSt');

        self::assertEquals('TEST', $string->toUpper());
    }

    /**
     * @covers \ArtARTs36\Str\Str::append
     */
    public function testAppend(): void
    {
        $stringOne = Str::make('test');

        self::assertEquals('test test', $stringOne->append('test', ' '));

        //

        $stringTwo = Str::make('test');

        self::assertEquals('test test', $stringTwo->append($stringTwo, ' '));

        //

        $stringThree = Str::make('test');

        $newString = $stringThree->append([
            'test',
            'test',
        ], ' ');

        self::assertEquals('test test test', $newString);
    }

    /**
     * @covers \ArtARTs36\Str\Str::lastSymbol
     */
    public function testLastSymbol(): void
    {
        $str = Str::make('test');

        self::assertEquals('t', $str->lastSymbol());
    }

    /**
     * @covers \ArtARTs36\Str\Str::firstSymbol
     */
    public function testFirstSymbol(): void
    {
        $str = Str::make('test');

        self::assertEquals('t', $str->firstSymbol());

        //

        $str = Str::make('');

        self::expectException(\LogicException::class);

        $str->firstSymbol();
    }

    /**
     * @covers \ArtARTs36\Str\Str::cut
     */
    public function testCut(): void
    {
        $str = Str::make('abcd');

        self::assertEquals('ab', $str->cut(2));
        self::assertEquals('cd', $str->cut(2, 2));
    }

    /**
     * @covers \ArtARTs36\Str\Str::isUpper
     */
    public function testIsUpper(): void
    {
        self::assertFalse(Str::make('tEsT')->isUpper());
        self::assertFalse(Str::make('test')->isUpper());
        self::assertTrue(Str::make('TEST')->isUpper());
    }

    /**
     * @covers \ArtARTs36\Str\Str::isLower
     */
    public function testIsLower(): void
    {
        self::assertFalse(Str::make('tEsT')->isLower());
        self::assertTrue(Str::make('test')->isLower());
        self::assertFalse(Str::make('TEST')->isLower());
    }

    /**
     * @covers \ArtARTs36\Str\Str::substring
     */
    public function testSubstring(): void
    {
        self::assertEquals('Te', Str::make('Test')->substring(0, 2)->__toString());
        self::assertEquals('Testin', Str::make('Testing')->substring(0, 6)->__toString());
    }

    /**
     * @covers \ArtARTs36\Str\Str::deleteLastSymbol
     */
    public function testDeleteLastSymbol(): void
    {
        self::assertEquals('Testin', Str::make('Testing')->deleteLastSymbol()->__toString());
    }
}
