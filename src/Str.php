<?php

namespace ArtARTs36\Str;

/**
 * Class Str
 * @package ArtARTs36\Str
 */
class Str implements \Countable
{
    protected const DEFAULT_ENCODING = 'UTF-8';

    /** @var string */
    protected $string;

    /**
     * String constructor.
     * @param string|object $string
     */
    public function __construct($string)
    {
        $this->string = $this->prepare($string);
    }

    /**
     * @param string|object|integer $string
     * @return static
     */
    public static function make($string): self
    {
        return new static($string);
    }

    /**
     * @param Str $needle
     * @return bool
     */
    public function contains($needle): bool
    {
        return (bool) preg_match("/{$this->prepare($needle)}/i", $this->string);
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
        $lines = explode("\n", $this->string);

        return count($lines);
    }

    /**
     * @return Str[]
     */
    public function lines(): array
    {
        return array_map(function (string $line) {
            return new static($line);
        }, explode("\n", $this->string));
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
     * @return array
     */
    public function chars(): array
    {
        $chars = [];

        if (function_exists('mb_str_split')) {
            return mb_str_split($this->string);
        }

        for ($i = 0; $i < $this->count(); $i++) {
            $chars[] = mb_substr($this->string, $i, 1);
        }

        return $chars;
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
    protected function prepare($string): string
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
            $appends = implode($delimiter, array_map('strval', $string));

            return new static($this->string . $delimiter . $appends);
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
        return new static(mb_substr($this->string, $start, $length, 'UTF-8'));
    }

    public function deleteLastSymbol(): Str
    {
        return new static(mb_substr($this->string, 0, -1));
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

    /**
     * @param string $string
     * @param string $delimiter
     * @return $this
     */
    protected function createWithAppend(string $string, string $delimiter = ''): self
    {
        return new static($this->string . $delimiter . $string);
    }
}
