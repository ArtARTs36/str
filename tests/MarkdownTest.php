<?php

namespace ArtARTs36\Str\Tests;

use ArtARTs36\Str\Markdown\MarkdownList;
use ArtARTs36\Str\Markdown\MarkdownString;
use ArtARTs36\Str\Markdown\WhitespaceLine;
use ArtARTs36\Str\MarkdownHeading;
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

    public function providerForTestHeadings(): array
    {
        return [
            [
                "## AA\n### BB",
                [
                    'headings' => [
                        [
                            'title' => 'AA',
                            'level' => 2,
                        ],
                        [
                            'title' => 'BB',
                            'level' => 3,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Markdown::headings
     * @dataProvider providerForTestHeadings
     */
    public function testHeadings(string $content, array $expected): void
    {
        $markdown = Str::make($content)->markdown();

        self::assertEquals($expected, $markdown->headings(true)->toArray());
    }

    public static function providerForTestElements(): array
    {
        return [
            [
                'markdownText' => <<<HTML
## v1.0.0

### Added
* item 1
* item 2

### Added
* item 1
* item 2
* item 3

### Added
* item 1
* item 2

Other text
HTML,
                'expected' => [
                    new MarkdownHeading(
                        new Str('v1.0.0'),
                        2
                    ),
                    new WhitespaceLine(),
                    new MarkdownHeading(
                        new Str('Added'),
                        3
                    ),
                    new MarkdownList([
                        new MarkdownString(new Str('item 1')),
                        new MarkdownString(new Str('item 2')),
                    ]),
                    new WhitespaceLine(),
                    new MarkdownHeading(
                        new Str('Added'),
                        3
                    ),
                    new MarkdownList([
                        new MarkdownString(new Str('item 1')),
                        new MarkdownString(new Str('item 2')),
                        new MarkdownString(new Str('item 3')),
                    ]),
                    new WhitespaceLine(),
                    new MarkdownHeading(
                        new Str('Added'),
                        3
                    ),
                    new MarkdownList([
                        new MarkdownString(new Str('item 1')),
                        new MarkdownString(new Str('item 2')),
                    ]),
                    new WhitespaceLine(),
                    new MarkdownString(new Str('Other text')),
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\Str\Markdown::elements
     *
     * @dataProvider providerForTestElements
     */
    public function testElements(string $markdownText, array $expected): void
    {
        self::assertSame(
            serialize($expected),
            serialize(Str::make($markdownText)->markdown()->elements())
        );
    }
}
