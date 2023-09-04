<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Exceptions\InvalidRegexException;
use ArtARTs36\Str\Markdown\MarkdownElement;
use ArtARTs36\Str\Markdown\MarkdownList;
use ArtARTs36\Str\Markdown\MarkdownString;
use ArtARTs36\Str\Markdown\WhitespaceLine;

class Markdown
{
    /** @var Str */
    private $str;

    public function __construct(
        Str $str
    ) {
        $this->str = $str;
    }

    public function str(): Str
    {
        return $this->str;
    }

    /**
     * @throws InvalidRegexException
     */
    public function containsHeadingWithLevel(string $title, int $level): bool
    {
        if ($level < 1 || $level > 6) {
            throw new \InvalidArgumentException(sprintf('Argument "level" must be in range 1-6. Given: %d', $level));
        }

        $regex = sprintf('/^#{%d}\s+%s/m', $level, $title);

        return $this->str->match($regex)->isNotEmpty();
    }

    /**
     * @throws InvalidRegexException
     */
    public function containsHeadingWithAnyLevel(string $title): bool
    {
        $regex = sprintf('/^(#*)\s+%s/m', $title);

        return $this->str->match($regex)->isNotEmpty();
    }

    public function headings(bool $trim = false): MarkdownHeadings
    {
        $matches = [];

        preg_match_all('/^(#*)(.*)/m', $this->str, $matches, PREG_SET_ORDER);

        $headings = [];

        foreach ($matches as [$_, $gratings, $title]) {
            $title = Str::make($title);

            $headings[] = new MarkdownHeading(
                $trim ? $title->trim() : $title,
                mb_strlen($gratings)
            );
        }

        return new MarkdownHeadings($headings);
    }

    /**
     * @return array<MarkdownElement>
     */
    public function elements(bool $ignoreWhitespaceLines = false): array
    {
        $elements = [];
        $list = null;

        foreach ($this->str->lines() as $line) {
            $line = $line->trim();

            if ($line->isEmpty()) {
                if (! $ignoreWhitespaceLines) {
                    $elements[] = new WhitespaceLine();
                }

                $list = null;

                continue;
            }

            if ($line->startsWith('#')) {
                $headingLevel = 1;
                $list = null;
                $maxLength = 5;

                if ($line->length() < $maxLength) {
                    $maxLength = $line->length();
                }

                $headingLevel += $line->countOfSymbolRepeatsInStart('#', 1, $maxLength);

                $elements[] = new MarkdownHeading(
                    $line->cut(null, $headingLevel + 1),
                    $headingLevel
                );

                continue;
            }

            if ($line->startsWithAnyOf(['*', '-'])) {
                if ($list === null) {
                    $list = new MarkdownList([]);
                    $elements[] = $list;
                }

                $list->items[] = new MarkdownString($line->cut(null, 2));

                continue;
            }

            $elements[] = new MarkdownString($line);
        }

        return $elements;
    }
}
