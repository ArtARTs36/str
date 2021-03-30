<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Exceptions\EmptyStringNotAllowedOperation;
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

        self::assertEquals(['t', 'e', 's', 't'], $chars);

        //

        $string = Str::make('Водка');

        $chars = $string->chars();

        self::assertEquals(['В', 'о', 'д', 'к', 'а'], $chars);
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

        self::expectException(EmptyStringNotAllowedOperation::class);

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

    public function testDeleteRepeatSymbolInEnding(): void
    {
        self::assertEquals('Hello//Dev', Str::make('Hello//Dev////')->deleteRepeatSymbolInEnding('/'));
    }

    /**
     * @covers \ArtARTs36\Str\Str::getSequencesByRepeatSymbols
     */
    public function testGetSequencesByRepeatSymbols(): void
    {
        $string = 'AAAA, Abcd OOOO';

        $expected = [
            [
                'A',
                'A',
                'A',
                'A',
            ],
            [
                ',',
            ],
            [
                ' ',
            ],
            [
                'A',
            ],
            [
                'b',
            ],
            [
                'c',
            ],
            [
                'd',
            ],
            [
                ' ',
            ],
            [
                'O',
                'O',
                'O',
                'O',
            ]
        ];

        self::assertEquals($expected, Str::make($string)->getSequencesByRepeatSymbols());
    }

    /**
     * @covers \ArtARTs36\Str\Str::positions
     */
    public function testPositions(): void
    {
        $string = 'Hello Hello Hello Artem Hello Artem Hello Artem Artem';

        $str = Str::make($string);

        self::assertEmpty($str->positions('artem'));
        self::assertEquals([18, 30, 42, 48], $str->positions('artem', true));
        self::assertEquals([0, 6, 12, 24, 36], $str->positions('Hello'));
    }

    /**
     * @covers \ArtARTs36\Str\Str::reverse
     * @dataProvider reverseDataProvider
     */
    public function testReverse(string $input, string $output): void
    {
        self::assertEquals($output, Str::make($input)->reverse()->__toString());
    }

    public function reverseDataProvider(): array
    {
        return [
            [
                'Artem',
                'metrA',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Str::prepend
     */
    public function testPrepend(): void
    {
        $str = Str::make('Artem')->prepend('Hello,', ' ');

        self::assertEquals('Hello, Artem', $str->__toString());
    }

    /**
     * @covers \ArtARTs36\Str\Str::getIterator
     * @dataProvider getIteratorProvider
     */
    public function testGetIterator(string $input, array $chars): void
    {
        $str = Str::make($input);

        self::assertEquals($chars, $str->getIterator()->getArrayCopy());
    }

    public function getIteratorProvider(): array
    {
        return [
            [
                'test',
                [
                    't',
                    'e',
                    's',
                    't',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Str::deleteFirstSymbol
     */
    public function testDeleteFirstSymbol(): void
    {
        self::assertEquals('ev', Str::make('Dev')->deleteFirstSymbol());
    }

    /**
     * @covers \ArtARTs36\Str\Str::delete
     */
    public function testDelete(): void
    {
        $subs = [
            'Test',
            'A',
        ];

        $string = 'Test A B';

        self::assertEquals('  B', Str::make($string)->delete($subs));
        self::assertEquals('B', Str::make($string)->delete($subs, true));
    }

    /**
     * @covers \ArtARTs36\Str\Str::trim
     */
    public function testTrim(): void
    {
        self::assertEquals("Test", Str::make(" Test  ")->trim());
    }

    /**
     * @covers \ArtARTs36\Str\Str::words
     */
    public function testWords(): void
    {
        self::assertEquals(['Test', '123'], Str::make('Test 123')->words());
    }

    /**
     * @covers \ArtARTs36\Str\Str::isEmpty
     */
    public function testIsEmpty(): void
    {
        self::assertTrue(Str::make('')->isEmpty());
        self::assertTrue(Str::make(' ')->isEmpty());
        self::assertFalse(Str::make('Hello')->isEmpty());
    }

    /**
     * @covers \ArtARTs36\Str\Str::usingLetters
     */
    public function testUsingLetters(): void
    {
        self::assertEquals(['A', 'B', 'C', 'D',], Str::make('AABBBCCCDDD')->usingLetters());
    }

    /**
     * @covers \ArtARTs36\Str\Str::getLettersStat
     */
    public function testGetLettersStat(): void
    {
        self::assertEquals([
            'A' => 2,
            'B' => 3,
        ], Str::make('AABBB')->getLettersStat()->getDict());
    }

    /**
     * @covers \ArtARTs36\Str\Str::upWords
     * @dataProvider upWordsDataProvider
     */
    public function testUpWords(string $input, string $expected): void
    {
        self::assertEquals($expected, Str::make($input)->upWords());
    }

    public function upWordsDataProvider(): array
    {
        return [
            [
                'hello artem',
                'Hello Artem',
            ],
            [
                'Hello Artem',
                'Hello Artem',
            ]
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Str::sortByChars
     */
    public function testSortByChars(): void
    {
        self::assertEquals('ABCD', Str::make('CDBA')->sortByChars());
        self::assertEquals('DCBA', Str::make('ABCD')->sortByChars(SORT_DESC));
    }

    /**
     * @covers \ArtARTs36\Str\Str::sortByWordsLengths
     */
    public function testSortByWordsLengths(): void
    {
        self::assertEquals('A BBB CCCC DDDDD', Str::make('BBB A DDDDD CCCC')->sortByWordsLengths());
        self::assertEquals('DDDDD CCCC BBB A', Str::make('BBB A DDDDD CCCC')
            ->sortByWordsLengths(SORT_DESC));
    }

    /**
     * @covers \ArtARTs36\Str\Str::upFirstSymbol
     */
    public function testUpFirstSymbol(): void
    {
        self::assertEquals('Hello', Str::make('hello')->upFirstSymbol());
        self::assertEquals('Артем', Str::make('артем')->upFirstSymbol());
    }

    /**
     * @covers \ArtARTs36\Str\Str::sentences
     */
    public function testSentences(): void
    {
        self::assertEquals(['hello', 'artem'], Str::make('hello.artem')->sentences());
        self::assertEquals(['hello', 'artem'], Str::make('hello.artem.')->sentences());
    }

    /**
     * @covers \ArtARTs36\Str\Str::containsAny
     */
    public function testContainsAny(): void
    {
        self::assertTrue(Str::make('hello')->containsAny([
            'he',
            'ff',
        ]));

        self::assertFalse(Str::make('ff')->containsAny([
            'he',
            'aa',
        ]));
    }

    /**
     * @covers \ArtARTs36\Str\Str::match
     */
    public function testMatch(): void
    {
        $str = Str::make('tests test');

        self::assertEquals('test', $str->match('/test/i')->__toString());
    }
}
