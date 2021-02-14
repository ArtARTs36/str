<?php

namespace ArtARTs36\Str\Support;

class LettersStat implements \Countable, \IteratorAggregate
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

    /**
     * @return array<string, int>
     */
    public function getByMaxInputs(): array
    {
        $max = $this->getMaxInputs();

        return $this->findBy(function (string $letter, int $inputs) use ($max) {
            return $inputs === $max;
        });
    }

    /**
     * @return array<string, int>
     */
    public function getByMinInputs(): array
    {
        $min = $this->getMinInputs();

        return $this->findBy(function (string $letter, int $inputs) use ($min) {
            return $inputs === $min;
        });
    }

    /**
     * @return array<string, int>
     */
    public function findBy(callable $criteria): array
    {
        $letters = [];

        foreach ($this->dict as $letter => $inputs) {
            if ($criteria($letter, $inputs)) {
                $letters[$letter] = $inputs;
            }
        }

        return $letters;
    }

    public function getMaxInputs(): int
    {
        return max(...array_values($this->dict));
    }

    public function getMinInputs(): int
    {
        return min(...array_values($this->dict));
    }

    public function count(): int
    {
        return count($this->dict);
    }

    public function getDict(): array
    {
        return $this->dict;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->dict);
    }
}
