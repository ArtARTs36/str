<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Support\Arr;

/**
 * @template-implements \IteratorAggregate<Str>
 * @template-implements \ArrayAccess<int, Str>
 */
class StrCollection implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /** @var array<Str> */
    protected $strs;

    /**
     * @param array<Str> $strings
     */
    final public function __construct(array $strings)
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
     * @return \Traversable<Str>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->strs);
    }

    public function count(): int
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

    /**
     * @return array<string>
     */
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
        $filtered = $callback === null ? array_filter($this->strs) : array_filter($this->strs, $callback);

        return new static($filtered);
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

    /**
     * @return array<mixed>
     */
    public function mapToArray(callable $callback): array
    {
        return array_map($callback, $this->strs);
    }

    public function first(): ?Str
    {
        return $this->strs[array_key_first($this->strs)] ?? null;
    }

    public function last(): ?Str
    {
        $last = Arr::last($this->strs);

        return $last === false ? null : $last;
    }

    public function slice(int $offset, ?int $length = null): self
    {
        return new static(array_slice($this->strs, $offset, $length));
    }

    /**
     * @param array<int> $keys
     */
    public function exceptKeys(array $keys): self
    {
        return new static(Arr::exceptKeys($this->strs, $keys));
    }

    public function onlyNotEmpty(): self
    {
        return $this->filter(function (Str $str) {
            return $str->isNotEmpty();
        });
    }

    /**
     * @return array<Str>
     */
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
        return $this->implode(' ')->toSentence();
    }

    public function toLower(): self
    {
        return $this->map(function (Str $str) {
            return $str->toLower();
        });
    }

    /**
     * @param int $offset
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->strs);
    }

    /**
     * @param int $offset
     */
    public function offsetGet($offset): ?Str
    {
        return $this->strs[$offset] ?? null;
    }

    /**
     * @param int $offset
     * @param Str $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new \LogicException('Str Collection is Immutable');
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset): void
    {
        throw new \LogicException('Str Collection is Immutable');
    }

    /**
     * Get longest common prefix.
     */
    public function commonPrefix(): Str
    {
        if ($this->isEmpty()) {
            return Str::fromEmpty();
        }

        $count = $this->count();

        if ($count === 1) {
            return $this->first(); // @phpstan-ignore-line
        }

        /** @var Str $firstStr */
        $firstStr = $this->first();
        $maxLength = $firstStr->length();
        $prefix = '';

        for ($index = 0; $index < $maxLength; $index++) {
            $symbol = $firstStr->getSymbolByIndex($index);

            for ($comparedIndex = 1; $comparedIndex < $count; $comparedIndex++) {
                if ($symbol !== $this[$comparedIndex]->getSymbolByIndex($index)) { // @phpstan-ignore-line
                    break 2;
                }
            }

            $prefix .= $symbol;
        }

        return Str::make($prefix);
    }
}
