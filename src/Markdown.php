<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Exceptions\InvalidRegexException;

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
}
