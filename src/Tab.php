<?php

namespace ArtARTs36\Str;

class Tab
{
    /**
     * @param non-empty-array<string> $strings
     */
    public static function maxLength(array $strings): int
    {
        $max = max(array_map('mb_strlen', $strings));

        return $max === false ? 0 : $max;
    }

    /**
     * @param non-empty-array<string> $strings
     * @return array<string>
     */
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
