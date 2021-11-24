<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Support\Arr;

class StrCollection implements \IteratorAggregate, \Countable, \ArrayAccess
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

    public function implodeAsLines(): Str
    {
        return $this->implode("\n");
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

    public function filter(?callable $callback = null): self
    {
        return new static(array_filter($this->strs, $callback));
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

    public function first(): ?Str
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

    public function exceptKeys(array $keys): self
    {
        return new static(Arr::exceptKeys($this->strs, $keys));
    }

    public function onlyNotEmpty(): self
    {
        return new static(array_filter($this->strs, function (Str $str) {
            return $str->isNotEmpty();
        }));
    }

    public function toArray(): array
    {
        return $this->strs;
    }

    public function maxLength(): int
    {
        return max(...$this->mapToArray('mb_strlen'));
    }

    public function toSentence(): Str
    {
        return $this->implode(' ')->rightTrim('.')->upFirstSymbol()->append('.');
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->strs);
    }

    public function offsetGet($offset): ?Str
    {
        return $this->strs[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        throw new \LogicException('Str Collection is Immutable');
    }

    public function offsetUnset($offset): void
    {
        throw new \LogicException('Str Collection is Immutable');
    }
}
