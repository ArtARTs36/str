<?php

namespace ArtARTs36\Str\Support;

trait Sortable
{
    /**
     * @return array<string>
     */
    abstract public function chars(): array;

    abstract public function __toString(): string;

    public function sortByChars(int $direction = SORT_ASC): self
    {
        $ords = array_map('ord', $this->chars());

        $sorted = implode('', array_map('chr', $this->sortArray($ords, $direction)));

        return new static($sorted);
    }

    public function sortByWordsLengths(int $direction = SORT_ASC, bool $excludeDots = false): self
    {
        $str = $excludeDots ? str_replace('.', '', $this->__toString()) : $this->__toString();

        $words = $this->sortArray(explode(' ', $str), $direction);

        return new static(implode(' ', $words));
    }

    private function sortArray(array $ords, int $direction): array
    {
        if ($direction === SORT_ASC) {
            sort($ords);
        } else {
            rsort($ords);
        }

        return $ords;
    }
}
