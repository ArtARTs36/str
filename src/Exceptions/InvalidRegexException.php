<?php

namespace ArtARTs36\Str\Exceptions;

final class InvalidRegexException extends \Exception
{
    public static function create(string $regex): self
    {
        return new self(sprintf('Regex "%s" is invalid', $regex));
    }
}
