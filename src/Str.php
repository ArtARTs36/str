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
     * @param string|object $string
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
    public function multiply(int $count, string $delimiter = ''): self
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
    public function count()
    {
        return mb_strlen($this->string);
    }

    /**
     * @param Str|string|object $string
     * @return bool
     */
    public function equals($string): bool
    {
        return $this->prepare($string) === $string;
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

        for ($i = 0; $i < $this->count(); $i++) {
            $chars[] = $this->string[$i];
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
     * @param Str|string|object $string
     * @return string
     */
    protected function prepare($string): string
    {
        if (is_string($string)) {
            return $string;
        } elseif (is_object($string) && method_exists($string, '__toString')) {
            return $string->__toString();
        } else {
            throw new \LogicException('Type not access');
        }
    }

    /**
     * @return string
     */
    public function toUpper(): string
    {
        return new static(mb_strtoupper($this->string, static::DEFAULT_ENCODING));
    }

    /**
     * @return string
     */
    public function toLower(): string
    {
        return new static(mb_strtolower($this->string, static::DEFAULT_ENCODING));
    }

    /**
     * @param string|Str|object $string
     * @param string $delimiter
     * @return Str
     */
    public function append($string, string $delimiter = ''): Str
    {
        if (is_string($string)) {
            return $this->createWithAppend($string, $delimiter);
        } elseif (is_object($string) && method_exists($string, '__toString')) {
            return $this->createWithAppend($string->__toString(), $delimiter);
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
