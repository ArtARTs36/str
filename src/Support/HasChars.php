<?php

namespace ArtARTs36\Str\Support;

trait HasChars
{
    protected $chars = null;

    abstract public function __toString(): string;

    abstract public function count(): int;

    /**
     * @return array
     */
    public function chars(): array
    {
        if ($this->chars !== null) {
            return $this->chars;
        }

        $chars = [];

        if (function_exists('mb_str_split')) {
            return $this->chars = mb_str_split($this->__toString());
        }

        for ($i = 0; $i < $this->count(); $i++) {
            $chars[] = mb_substr($this->__toString(), $i, 1);
        }

        return $this->chars = $chars;
    }
}
