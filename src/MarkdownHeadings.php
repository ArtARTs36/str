<?php

namespace ArtARTs36\Str;

class MarkdownHeadings implements \IteratorAggregate
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
        return count($this->headings);
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->headings);
    }
}
