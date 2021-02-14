<?php

namespace ArtARTs36\Str\Support;

class LettersStat implements \Countable
{
    protected $dict;

    /**
     * @param array<string, int> $dict
     */
    public function __construct(array $dict)
    {
        $this->dict = $dict;
    }

    public function inputs(string $letter): int
    {
        return $this->dict[$letter] ?? 0;
    }

    public function getLetterByMaxInputs(): ?string
    {
        $max = -1;
        $letter = null;

        foreach ($this->dict as $index => $inputs) {
            if ($max < $inputs) {
                $max = $inputs;
                $letter = $index;
            }
        }

        return $letter;
    }

    public function getMaxInputs(): int
    {
        return max(...array_values($this->dict));
    }

    public function count(): int
    {
        return count($this->dict);
    }

    public function getDict(): array
    {
        return $this->dict;
    }
}
