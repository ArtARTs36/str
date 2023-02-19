<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Str;
use PHPUnit\Framework\TestCase;

final class MarkdownTest extends TestCase
{
    public function providerForTestHasHeadingWithAnyLevel(): array
    {
        return [
            [
                'ddd
### Title
aa ### String',
                'Title',
                true,
            ],
            [
                'ddd
bb ### Title
aa ### String',
                'Title',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Markdown::containsHeadingWithAnyLevel
     * @dataProvider providerForTestHasHeadingWithAnyLevel
     */
    public function testHasHeadingWithAnyLevel(string $md, string $title, bool $expected): void
    {
        $markdown = Str::make($md)->markdown();

        self::assertEquals($expected, $markdown->containsHeadingWithAnyLevel($title));
    }

    public function providerForTestHasHeadingWithLevel(): array
    {
        return [
            [
                'ddd
### Title
aa ### String',
                'Title',
                3,
                true,
            ],
            [
                'ddd
## Title
aa ### String',
                'Title',
                3,
                false,
            ],
            [
                'ddd
bb ### Title
aa ### String',
                'Title',
                3,
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Markdown::containsHeadingWithLevel
     * @dataProvider providerForTestHasHeadingWithLevel
     */
    public function testHasHeadingWithLevel(string $md, string $title, int $level, bool $expected): void
    {
        $markdown = Str::make($md)->markdown();

        self::assertEquals($expected, $markdown->containsHeadingWithLevel($title, $level));
    }

    public function providerForTestHasHeadingWithLevelOnInvalidLevelRange(): array
    {
        return [
            ['', '', 0],
            ['', '', 7],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Markdown::containsHeadingWithLevel
     * @dataProvider providerForTestHasHeadingWithLevelOnInvalidLevelRange
     */
    public function testHasHeadingWithLevelOnInvalidLevelRange(string $md, string $title, int $level): void
    {
        $markdown = Str::make($md)->markdown();

        self::expectExceptionMessage('Argument "level" must be in range 1-6.');

        $markdown->containsHeadingWithLevel($title, $level);
    }
}
