<?php

namespace ArtARTs36\Str;

class Tab
{
    public static function maxLength(array $strings): int
    {
        return max(array_map('mb_strlen', $strings));
    }

    public static function addSpaces(array $strings, string $symbol = ' '): array
    {
        $length = static::maxLength($strings) + 1;
        $fixed = [];

        foreach ($strings as $string) {
            $suffixLength = $length - mb_strlen($string);
            $fixed[] = $string . str_repeat($symbol, $suffixLength);
        }

        return $fixed;
    }
}
