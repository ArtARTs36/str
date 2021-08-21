<?php

namespace ArtARTs36\Str\Support;

class Arr
{
    public static function sort(array $ords, int $direction): array
    {
        if ($direction === SORT_ASC) {
            sort($ords);
        } else {
            rsort($ords);
        }

        return $ords;
    }

    public static function exceptKeys(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    public static function uniques(array $array): array
    {
        return array_values(array_unique($array));
    }

    public static function withoutLastElement(array $array): array
    {
        array_pop($array);

        return $array;
    }

    public static function last(array $array)
    {
        return end($array);
    }
}
