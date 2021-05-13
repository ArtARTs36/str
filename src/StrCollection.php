<?php

namespace ArtARTs36\Str;

class StrCollection implements \IteratorAggregate, \Countable
{
    protected $strs;

    /**
     * @param array<Str> $strings
     */
    public function __construct(array $strings)
    {
        $this->strs = $strings;
    }

    public function implode(string $separator): Str
    {
        return Str::make(implode($separator, $this->strs));
    }

    /**
     * @return \ArrayIterator|iterable<Str>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->strs);
    }

    public function count()
    {
        return count($this->strs);
    }

    public function length(): int
    {
        return array_sum(array_map('count', $this->strs));
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    public function map(callable $callback): self
    {
        return new static(array_map($callback, $this->strs));
    }

    public function toStrings(): array
    {
        return array_map('strval', $this->strs);
    }

    public function trim(): self
    {
        return $this->map(function (Str $str) {
            return $str->trim();
        });
    }
}
