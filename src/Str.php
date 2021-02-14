<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Exceptions\EmptyStringNotAllowedOperation;
use ArtARTs36\Str\Support\HasChars;
use ArtARTs36\Str\Support\LettersStat;

/**
 * Class Str
 * @package ArtARTs36\Str
 */
class Str implements \Countable, \IteratorAggregate
{
    use HasChars;

    protected const DEFAULT_ENCODING = 'UTF-8';

    protected $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @param string|object|integer $string
     */
    public static function make($string): self
    {
        return new static(static::prepare($string));
    }

    /**
     * @param \Stringable|string|int|float $needle
     */
    public function contains($needle): bool
    {
        return preg_match("/{$this->prepare($needle)}/i", $this->string) !== false;
    }

    public function multiply(int $count, string $delimiter = ''): Str
    {
        $newString = '';

        for ($i = 1; $i < $count + 1; $i++) {
            $newString .= ($i === $count) ? $this->string : ($this->string . $delimiter);
        }

        return new static($newString);
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function linesCount(): int
    {
        return count($this->explodeLines());
    }

    /**
     * @return array<static>
     */
    public function lines(): array
    {
        return $this->arrayToSelfInstances($this->explodeLines());
    }

    /**
     * @return array<static>
     */
    public function words(): array
    {
        return $this->arrayToSelfInstances(explode(' ', $this->string));
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return mb_strlen($this->string);
    }

    /**
     * @param Str|string|\Stringable $string
     */
    public function equals($string, bool $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            return $this->prepare($this->prepareToLower($string)) === $this->prepareToLower($this->string);
        }

        return $this->prepare($string) === $this->string;
    }

    public function toStudlyCaps(): Str
    {
        return new static($this->prepareStudlyCaps($this->string));
    }

    public function isStudlyCaps(): bool
    {
        return $this->prepareStudlyCaps($this->string) === $this->string;
    }

    public function toCamelCase(): Str
    {
        return new static($this->prepareCamelCase($this->string));
    }

    public function isCamelCase(): bool
    {
        return $this->prepareCamelCase($this->string) === $this->string;
    }

    public function toUpper(): Str
    {
        return new static(mb_strtoupper($this->string, static::DEFAULT_ENCODING));
    }

    /**
     * @return array<string>
     */
    public function usingLetters(): array
    {
        return array_values(array_unique($this->chars()));
    }

    public function getLettersStat(): LettersStat
    {
        $stat = [];

        foreach ($this->chars() as $char) {
            if (! isset($stat[$char])) {
                $stat[$char] = 0;
            }

            $stat[$char]++;
        }

        return new LettersStat($stat);
    }

    public function isUpper(): bool
    {
        return mb_strtoupper($this->string, static::DEFAULT_ENCODING) === $this->string;
    }

    public function toLower(): Str
    {
        return new static($this->prepareToLower($this->string));
    }

    public function isLower(): bool
    {
        return $this->prepareToLower($this->string) === $this->string;
    }

    /**
     * @param string|Str|\Stringable|array|object[] $string
     */
    public function append($string, string $delimiter = ''): Str
    {
        return $this->edit($string, [$this, 'createWithAppend'], $delimiter);
    }

    /**
     * @param string|Str|\Stringable|array|object[] $string
     */
    public function prepend($string, string $delimiter = ''): Str
    {
        return $this->edit($string, [$this, 'createWithPrepend'], $delimiter);
    }

    /**
     * @return string
     */
    public function lastSymbol(): string
    {
        return $this->string[$this->count() - 1];
    }

    /**
     * @return string
     */
    public function firstSymbol(): string
    {
        if ($this->isEmpty()) {
            throw new EmptyStringNotAllowedOperation();
        }

        return $this->string[0];
    }

    public function isEmpty(): bool
    {
        return empty(trim($this->string));
    }

    public function cut(int $length, int $start = 0): Str
    {
        return new static(mb_strcut($this->string, $start, $length));
    }

    public function substring(int $start, int $length): Str
    {
        return new static(mb_substr($this->string, $start, $length, static::DEFAULT_ENCODING));
    }

    public function deleteLastSymbol(): Str
    {
        return $this->substring(0, -1);
    }

    public function deleteFirstSymbol(): Str
    {
        return $this->substring(1, $this->count());
    }

    public function deleteRepeatSymbolInEnding(string $symbol): Str
    {
        if ($this->lastSymbol() !== $symbol) {
            return $this;
        }

        $sequences = array_slice($this->getSequencesByRepeatSymbols(), 0, -1);

        return new static(implode('', array_map(function (array $part) {
            return implode('', $part);
        }, $sequences)));
    }

    public function getSequencesByRepeatSymbols(): array
    {
        $prev = '';
        $lastSequence = 0;
        $sequences = [];

        foreach ($this->chars() as $char) {
            if ($prev !== $char) {
                $lastSequence++;
            }

            $sequences[$lastSequence][] = $char;
            $prev = $char;
        }

        return array_values($sequences);
    }

    /**
     * @return array<int>
     */
    public function positions(string $find, bool $ignoreCase = false): array
    {
        $my = $ignoreCase ? mb_strtolower($this->string) : $this->string;
        $find = $ignoreCase ? mb_strtolower($find) : $find;
        $positions = [];
        $last = 0;
        $length = mb_strlen($find);

        while (($last = mb_strpos($my, $find, $last)) !== false) {
            $positions[] = $last;
            $last = $last + $length;
        }

        return $positions;
    }

    public function trim(): Str
    {
        return new static(trim($this->string));
    }

    public function reverse(): Str
    {
        return new static(strrev($this->string));
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->chars());
    }

    public function delete(array $subs, bool $trim = false): Str
    {
        $deleted = str_replace($this->prepareArray($subs), '', $this->string);

        return new static($trim ? trim($deleted) : $deleted);
    }

    /**
     * @param string $string
     * @param string $delimiter
     * @return $this
     */
    protected function createWithAppend(string $string, string $delimiter = ''): self
    {
        return new static($this->string . $delimiter . $string);
    }

    protected function createWithPrepend(string $string, string $delimiter = ''): self
    {
        return new static($string . $delimiter . $this->string);
    }

    protected function joinStrings(array $stringable, string $delimiter = ''): string
    {
        return implode($delimiter, $this->prepareArray($stringable));
    }

    /**
     * @param string $string
     * @return string
     */
    final protected function prepareStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $string)));
    }

    /**
     * @param string $string
     * @return string
     */
    final protected function prepareCamelCase(string $string): string
    {
        return lcfirst($this->prepareStudlyCaps($string));
    }

    /**
     * @param string $string
     * @return string
     */
    final protected function prepareToLower(string $string): string
    {
        return mb_strtolower($string, static::DEFAULT_ENCODING);
    }

    /**
     * @param Str|string|object $string
     * @return string
     */
    protected static function prepare($string): string
    {
        if (is_string($string)) {
            return $string;
        } elseif (is_object($string) && method_exists($string, '__toString')) {
            return $string->__toString();
        } elseif (is_numeric($string)) {
            return (string) $string;
        } else {
            throw new \LogicException('Type not access');
        }
    }

    protected function explodeLines(): array
    {
        return explode("\n", $this->string);
    }

    /**
     * @return array<string>
     */
    protected function prepareArray(array $array): array
    {
        return array_map('strval', $array);
    }

    /**
     * @param string|\Stringable|int|float|array $string
     */
    protected function edit($string, callable $edit, string $delimiter = ''): Str
    {
        if (is_string($string)) {
            return $edit($string, $delimiter);
        } elseif (is_object($string) && method_exists($string, '__toString')) {
            return $edit($string->__toString(), $delimiter);
        } elseif (is_numeric($string)) {
            return $edit((string) $string, $delimiter);
        } elseif (is_array($string)) {
            return $edit($this->joinStrings($string, $delimiter), $delimiter);
        }

        throw new \LogicException('Type not access');
    }

    /**
     * @return array<static>
     */
    protected function arrayToSelfInstances(array $array): array
    {
        return array_map(function (string $string) {
            return new static($string);
        }, $array);
    }
}
