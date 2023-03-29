<?php

namespace ArtARTs36\Str\Concerns;

use ArtARTs36\Str\Facade\Str as StaticString;

trait Randomize
{
    abstract public static function make(string $string): self;

    /**
     * Create instance from random symbols.
     * @param positive-int $maxLength
     */
    public static function random(int $maxLength = 6): self
    {
        return static::make(StaticString::random($maxLength));
    }

    public static function randomFix(int $length): self
    {
        return static::make(StaticString::randomFix($length));
    }
}
