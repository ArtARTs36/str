<?php

namespace ArtARTs36\Str;

class StrCollection implements \IteratorAggregate
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
}
