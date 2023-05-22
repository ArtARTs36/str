<?php

namespace ArtARTs36\Str;

/**
 * @template-implements \IteratorAggregate<MarkdownHeading>
 */
class MarkdownHeadings implements \IteratorAggregate, \Countable
{
    /** @var array<MarkdownHeading> */
    private $headings;

    /**
     * @param array<MarkdownHeading> $headings
     */
    public function __construct(
        array $headings
    ) {
        $this->headings = $headings;
    }

    /**
     * @return array<MarkdownHeading>
     */
    public function all(): array
    {
        return $this->headings;
    }

    /**
     * @return array{headings: array<array{title: string, level: int}>}
     */
    public function toArray(): array
    {
        $array = [
            'headings' => [],
        ];

        foreach ($this->headings as $heading) {
            $array['headings'][] = [
                'title' => $heading->title,
                'level' => $heading->level,
            ];
        }

        return $array;
    }

    public function filterByLevel(int $level): MarkdownHeadings
    {
        return $this->filter(function (MarkdownHeading $heading) use ($level) {
            return $heading->level === $level;
        });
    }

    /**
     * @param callable(MarkdownHeading): bool $filter
     */
    public function filter(callable $filter): MarkdownHeadings
    {
        return new MarkdownHeadings(array_filter($this->headings, $filter));
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return count($this->headings);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->headings);
    }
}
