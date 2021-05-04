<?php

namespace ArtARTs36\Str;

class StrCollection implements \IteratorAggregate, \Countable
{
    protected $strings;

    /**
     * @param array<Str> $strings
     */
    public function __construct(array $strings)
    {
        $this->strings = $strings;
    }

    public function implode(string $separator): Str
    {
        return Str::make(implode($separator, $this->strings));
    }

    /**
     * @return \ArrayIterator|iterable<Str>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->strings);
    }

    public function count()
    {
        return count($this->strings);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }
}
