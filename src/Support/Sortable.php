<?php

namespace ArtARTs36\Str\Support;

use ArtARTs36\Str\Facade\Str;

trait Sortable
{
    /**
     * @return array<string>
     */
    abstract public function chars(): array;

    abstract public function __toString(): string;

    public function sortByChars(int $direction = SORT_ASC): self
    {
        return new static(Str::sortByChars($this->string, $direction));
    }

    public function sortByWordsLengths(int $direction = SORT_ASC, bool $excludeDots = false): self
    {
        return new static(Str::sortByWordsLengths($this->string, $direction, $excludeDots));
    }
}
