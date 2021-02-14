<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Support\HasChars;

/**
 * Class Str
 * @package ArtARTs36\Str
 */
class Str implements \Countable, \IteratorAggregate
{
    use HasChars;

    protected const DEFAULT_ENCODING = 'UTF-8';

    /** @var string */
    protected $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @param string|object|integer $string
     * @return static
     */
    public static function make($string): self
    {
        return new static(static::prepare($string));
    }

    /**
     * @param Str $needle
     * @return bool
     */
    public function contains($needle): bool
    {
        return preg_match("/{$this->prepare($needle)}/i", $this->string) !== false;
    }

    /**
     * @param int $count
     * @param string $delimiter
     * @return $this
     */
    public function multiply(int $count, string $delimiter = ''): Str
    {
        $newString = '';

        for ($i = 1; $i < $count + 1; $i++) {
            $newString .= ($i === $count) ? $this->string : ($this->string . $delimiter);
        }

        return new static($newString);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * @return int
     */
    public function linesCount(): int
    {
        return count($this->explodeLines());
    }

    /**
     * @return Str[]
     */
    public function lines(): array
    {
        return array_map(function (string $line) {
            return new static($line);
        }, $this->explodeLines());
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return mb_strlen($this->string);
    }

    /**
     * @param Str|string|object $string
     * @param bool $ignoreCase
     * @return bool
     */
    public function equals($string, bool $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            return $this->prepare($this->prepareToLower($string)) === $this->prepareToLower($this->string);
        }

        return $this->prepare($string) === $this->string;
    }

    /**
     * @return Str
     */
    public function toStudlyCaps(): Str
    {
        return new static($this->prepareStudlyCaps($this->string));
    }

    /**
     * @return bool
     */
    public function isStudlyCaps(): bool
    {
        return $this->prepareStudlyCaps($this->string) === $this->string;
    }

    /**
     * @return Str
     */
    public function toCamelCase(): Str
    {
        return new static($this->prepareCamelCase($this->string));
    }

    /**
     * @return bool
     */
    public function isCamelCase(): bool
    {
        return $this->prepareCamelCase($this->string) === $this->string;
    }

    /**
     * @return Str
     */
    public function toUpper(): Str
    {
        return new static(mb_strtoupper($this->string, static::DEFAULT_ENCODING));
    }

    /**
     * @return bool
     */
    public function isUpper(): bool
    {
        return mb_strtoupper($this->string, static::DEFAULT_ENCODING) === $this->string;
    }

    /**
     * @return Str
     */
    public function toLower(): Str
    {
        return new static($this->prepareToLower($this->string));
    }

    /**
     * @return bool
     */
    public function isLower(): bool
    {
        return $this->prepareToLower($this->string) === $this->string;
    }

    /**
     * @param string|Str|object|array|object[] $string
     * @param string $delimiter
     * @return Str
     */
    public function append($string, string $delimiter = ''): Str
    {
        if (is_string($string)) {
            return $this->createWithAppend($string, $delimiter);
        } elseif (is_object($string) && method_exists($string, '__toString')) {
            return $this->createWithAppend($string->__toString(), $delimiter);
        } elseif (is_numeric($string)) {
            return $this->createWithAppend((string) $string, $delimiter);
        } elseif (is_array($string)) {
            return $this->createWithAppend($this->joinStrings($string, $delimiter), $delimiter);
        }

        throw new \LogicException('Type not access');
    }

    public function prepend($string, string $delimiter): Str
    {
        if (is_string($string)) {
            return $this->createWithPrepend($string, $delimiter);
        } elseif (is_object($string) && method_exists($string, '__toString')) {
            return $this->createWithPrepend($string->__toString(), $delimiter);
        } elseif (is_numeric($string)) {
            return $this->createWithPrepend((string) $string, $delimiter);
        } elseif (is_array($string)) {
            return $this->createWithPrepend($this->joinStrings($string, $delimiter), $delimiter);
        }

        throw new \LogicException('Type not access');
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
        if (empty($this->string)) {
            throw new \LogicException('String empty');
        }

        return $this->string[0];
    }

    /**
     * @param int $length
     * @param int $start
     * @return Str
     */
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
}
