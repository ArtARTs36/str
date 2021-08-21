<?php

namespace ArtARTs36\Str\Support;

use ArtARTs36\Str\Facade\Str;

trait HasChars
{
    protected $chars = null;

    abstract public function __toString(): string;

    abstract public function count(): int;

    /**
     * @return array<string>
     */
    public function chars(): array
    {
        if ($this->chars !== null) {
            return $this->chars;
        }

        return $this->chars = Str::chars($this->__toString());
    }
}
