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
}
