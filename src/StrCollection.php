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

    /**
     * @return array<int>
     */
    public function toIntegers(): array
    {
        return $this->mapToArray(function (Str $str) {
            return $str->toInteger();
        });
    }
    
    public function mapToArray(callable $callback): array
    {
        return array_map($callback, $this->strs);
    }

    public function first(): ?string
    {
        return $this->strs[array_key_first($this->strs)] ?? null;
    }

    public function last(): ?string
    {
        return end($this->strs);
    }

    public function slice(int $offset, ?int $length = null): self
    {
        return new static(array_slice($this->strs, $offset, $length));
    }

    public function onlyNotEmpty(): self
    {
        return new static(array_filter($this->strs, function (Str $str) {
            return $str->isNotEmpty();
        }));
    }
}
