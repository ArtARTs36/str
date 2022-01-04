<?php

namespace ArtARTs36\Str\Support;

class Arr
{
    /**
     * @param array<mixed> $ords
     * @return array<mixed>
     */
    public static function sort(array $ords, int $direction): array
    {
        if ($direction === SORT_ASC) {
            sort($ords);
        } else {
            rsort($ords);
        }

        return $ords;
    }

    /**
     * @param array<mixed, mixed> $array
     * @param array<string|int> $keys
     * @return array<mixed>
     */
    public static function exceptKeys(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * @param array<mixed> $array
     * @return array<mixed>
     */
    public static function uniques(array $array): array
    {
        return array_values(array_unique($array));
    }

    /**
     * @param array<mixed> $array
     * @return array<mixed>
     */
    public static function withoutLastElement(array $array): array
    {
        array_pop($array);

        return $array;
    }

    /**
     * @param array<mixed> $array
     * @return mixed
     */
    public static function last(array $array)
    {
        return end($array);
    }
}
