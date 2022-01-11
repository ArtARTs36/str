<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Support\Arr;
use ArtARTs36\Str\Support\HasChars;
use ArtARTs36\Str\Support\LettersStat;
use ArtARTs36\Str\Support\Sortable;
use ArtARTs36\Str\Facade\Str as StaticString;

/**
 * @template-implements \IteratorAggregate<string>
 */
class Str implements \Countable, \IteratorAggregate
{
    use Sortable;
    use HasChars;

    protected const DEFAULT_ENCODING = 'UTF-8';

    /** @var string */
    protected $string;

    final public function __construct(string $string)
    {
        $this->string = $string;
    }

    public static function make(string $string): self
    {
        return new static($string);
    }

    /**
     * Create instance from random symbols.
     */
    public static function random(int $maxLength = 6): self
    {
        return new static(StaticString::random($maxLength));
    }

    public static function randomFix(int $length): self
    {
        return new static(StaticString::randomFix($length));
    }

    /**
     * @param array<string|\Stringable> $array
     */
    public static function fromArray(array $array, string $separator = ''): self
    {
        return static::make(static::joinStrings($array, $separator));
    }

    /**
     * Create instance from empty string.
     */
    public static function fromEmpty(): self
    {
        return new static('');
    }

    public function contains(string $needle, bool $regex = false): bool
    {
        return $regex ?
            StaticString::regexContains($this->string, $needle) :
            StaticString::contains($this->string, $needle);
    }

    public function deleteUnnecessarySpaces(): Str
    {
        return new static(StaticString::deleteUnnecessarySpaces($this->string));
    }

    public function deleteAllLetters(): Str
    {
        return new static(StaticString::deleteAllLetters($this->string));
    }

    public function downFirstSymbol(): Str
    {
        return new static(StaticString::downFirstSymbol($this->string));
    }

    /**
     * Cast value to integer.
     */
    public function toInteger(): int
    {
        return StaticString::toInteger($this->string);
    }

    /**
     * Cast value to float.
     */
    public function toFloat(): ?float
    {
        return StaticString::toFloat($this->string);
    }

    /**
     * @param array<\Stringable|string|int|float> $needles
     */
    public function containsAny(array $needles, bool $regex = false): bool
    {
        return $regex ?
            StaticString::regexContainsAny($this->string, $needles) :
            StaticString::containsAny($this->string, $needles);
    }

    /**
     * @param array<\Stringable|string|int|float> $needles
     */
    public function containsAll(array $needles): bool
    {
        return StaticString::containsAll($this->string, $needles);
    }

    public function multiply(int $count, string $delimiter = ''): Str
    {
        return new static(StaticString::multiply($this->string, $count, $delimiter));
    }

    /**
     * @return array<mixed>
     */
    public function globalMatch(string $pattern, int $flags = PREG_SET_ORDER, int $offset = 0): array
    {
        return StaticString::globalMatch(
            $this->string,
            $pattern,
            $flags,
            $offset
        );
    }

    public function match(string $pattern, int $flags = 0, int $offset = 0, bool $end = true): self
    {
        return new static(StaticString::match($this->string, $pattern, $flags, $offset, $end));
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function linesCount(): int
    {
        return StaticString::linesCount($this->string);
    }

    public function lines(): StrCollection
    {
        return $this->arrayToCollection(StaticString::lines($this->string));
    }

    public function words(): StrCollection
    {
        return $this->explode(StaticString::SEPARATOR_WORD);
    }

    public function sentences(): StrCollection
    {
        return $this->arrayToCollection(array_values(array_filter(StaticString::sentences($this->string))));
    }

    /**
     * Get length of string. Alias of @see Str::length()
     */
    public function count(): int
    {
        return $this->length();
    }

    /**
     * Get length of string.
     */
    public function length(): int
    {
        return mb_strlen($this->string);
    }

    /**
     * @param Str|string|\Stringable $string
     */
    public function equals($string, bool $ignoreCase = false): bool
    {
        return StaticString::equals($this->string, $string, $ignoreCase);
    }

    public function toStudlyCaps(): Str
    {
        return new static(StaticString::toStudly($this->string));
    }

    public function isStudlyCaps(): bool
    {
        return StaticString::isStudly($this->string);
    }

    public function toCamelCase(): Str
    {
        return new static(StaticString::toCamel($this->string));
    }

    public function isCamelCase(): bool
    {
        return StaticString::isCamel($this->string);
    }

    public function toUpper(): Str
    {
        return new static(StaticString::toUpper($this->string));
    }

    /**
     * @return array<string>
     */
    public function usingLetters(): array
    {
        return Arr::uniques($this->chars());
    }

    public function getLettersStat(): LettersStat
    {
        return StaticString::getLettersStat($this->string);
    }

    public function isUpper(): bool
    {
        return StaticString::isUpper($this->string);
    }

    public function toLower(): Str
    {
        return new static(StaticString::toLower($this->string));
    }

    public function isLower(): bool
    {
        return StaticString::isLower($this->string);
    }

    /**
     * @param string|Str|\Stringable|array<\Stringable> $string
     */
    public function append($string, string $delimiter = ''): Str
    {
        return $this->edit($string, [$this, 'createWithAppend'], $delimiter);
    }

    /**
     * @param string|Str|\Stringable|array<\Stringable> $string
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
        return StaticString::lastSymbol($this->string);
    }

    /**
     * @return string
     */
    public function firstSymbol(): string
    {
        return StaticString::firstSymbol($this->string);
    }

    public function shuffle(): self
    {
        return new static(StaticString::shuffle($this->string));
    }

    public function isEmpty(): bool
    {
        return StaticString::isEmpty($this->string);
    }

    public function cut(?int $length, int $start = 0): Str
    {
        return new static(StaticString::cut($this->string, $length, $start));
    }

    public function substring(int $start, int $length): Str
    {
        return new static(StaticString::substring($this->string, $start, $length));
    }

    public function deleteLastSymbol(): Str
    {
        return $this->substring(0, -1);
    }

    public function deleteFirstSymbol(): Str
    {
        return $this->substring(1, $this->count());
    }

    /**
     * @return array<int>
     */
    public function getBytes(): array
    {
        return StaticString::getBytes($this->string);
    }

    public function deleteRepeatSymbolInEnding(string $symbol): Str
    {
        return new static(StaticString::deleteRepeatSymbolInEnding($this->string, $symbol));
    }

    /**
     * @param non-empty-string $sep
     */
    public function explode(string $sep): StrCollection
    {
        return $this->arrayToCollection(StaticString::explode($this->string, $sep));
    }

    /**
     * @param non-empty-string $separator
     */
    public function slice(string $separator, int $length, int $offset = 0): self
    {
        return new static(StaticString::slice($this->string, $separator, $length, $offset));
    }

    /**
     * @return array<array<string>>
     */
    public function getSequencesByRepeatSymbols(): array
    {
        return StaticString::getSequencesByRepeatSymbols($this->string);
    }

    /**
     * @return array<int>
     */
    public function positions(string $find, bool $ignoreCase = false): array
    {
        return StaticString::positions($this->string, $find, $ignoreCase);
    }

    public function trim(): Str
    {
        return new static(StaticString::trim($this->string));
    }

    public function reverse(): Str
    {
        return new static(StaticString::reverse($this->string));
    }

    public function getNumbersCountInEnding(): int
    {
        return StaticString::getNumbersCountInEnding($this->string);
    }

    /**
     * @return \ArrayIterator<int, string>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->chars());
    }

    /**
     * @param array<string|\Stringable> $subs
     */
    public function delete(array $subs, bool $trim = false): Str
    {
        return new static(StaticString::delete($this->string, $subs, $trim));
    }

    public function deleteLastLine(): Str
    {
        return new static(StaticString::deleteLastLine($this->string));
    }

    public function getLastLine(): Str
    {
        return new static(StaticString::getLastLine($this->string));
    }

    public function startsWith(string $needle): bool
    {
        return StaticString::startsWith($this->string, $needle);
    }

    public function endsWith(string $needle): bool
    {
        return StaticString::endsWith($this->string, $needle);
    }

    /**
     * @param array<string, string> $replaces
     */
    public function replace(array $replaces): Str
    {
        return new static(StaticString::replace($this->string, $replaces));
    }

    public function upWords(): Str
    {
        return new static(StaticString::upWords($this->string));
    }

    /**
     * @param Str|string|object $needle
     */
    public function hasLine($needle, bool $trim = true): bool
    {
        return StaticString::hasLine($this->string, (string) $needle, $trim);
    }

    public function upFirstSymbol(): Str
    {
        return new static(StaticString::upFirstSymbol($this->string));
    }

    public function hashCode(): int
    {
        return StaticString::hashCode($this->string);
    }

    public function hasUppercaseSymbols(): bool
    {
        return StaticString::hasUppercaseSymbols($this->string);
    }

    public function hasLowercaseSymbols(): bool
    {
        return StaticString::hasLowercaseSymbols($this->string);
    }

    public function isDigit(): bool
    {
        return StaticString::isDigit($this->string);
    }

    public function resize(int $length, string $lack = '0', bool $lackInStart = true): self
    {
        return new static(StaticString::resize($this->string, $length, $lack, $lackInStart));
    }

    public function isNotEmpty(): bool
    {
        return StaticString::isNotEmpty($this->string);
    }

    public function firstWord(): self
    {
        return new static(StaticString::firstWord($this->string));
    }

    public function appendEmptyLine(): Str
    {
        return $this->appendLine('');
    }

    public function appendLine(string $line): Str
    {
        return $this->append("\n$line");
    }

    public function leftTrim(string $characters = " \t\n\r\0\x0B"): Str
    {
        return new static(ltrim($this->string, $characters));
    }

    public function rightTrim(string $characters = " \t\n\r\0\x0B"): Str
    {
        return new static(rtrim($this->string, $characters));
    }

    public function swapCase(): self
    {
        return new static(StaticString::swapCase($this->string));
    }

    public function toSnakeCase(string $separator = '_'): self
    {
        return new static(StaticString::toSnakeCase($this->string, $separator));
    }

    public function splitByDifferentCases(): StrCollection
    {
        return $this->arrayToCollection(StaticString::splitByDifferentCases($this->string));
    }

    public function deleteWhenEnds(string $needle): Str
    {
        return new static(StaticString::deleteWhenEnds($this->string, $needle));
    }

    public function findUris(): StrCollection
    {
        return $this->arrayToCollection(StaticString::findUris($this->string));
    }

    /**
     * Convert to sentence.
     */
    public function toSentence(): Str
    {
        return $this->rightTrim('.')->upFirstSymbol()->append('.');
    }

    protected function createWithAppend(string $string, string $delimiter = ''): self
    {
        return new static($this->string . $delimiter . $string);
    }

    protected function createWithPrepend(string $string, string $delimiter = ''): self
    {
        return new static($string . $delimiter . $this->string);
    }

    /**
     * @param array<string|\Stringable> $stringable
     */
    protected static function joinStrings(array $stringable, string $delimiter = ''): string
    {
        return implode($delimiter, static::prepareArray($stringable));
    }

    /**
     * @param array<string|\Stringable> $array
     * @return array<string>
     */
    protected static function prepareArray(array $array): array
    {
        return array_map('strval', $array);
    }

    /**
     * @param string|\Stringable|int|float|array<string|\Stringable> $string
     */
    protected function edit($string, callable $edit, string $delimiter = ''): Str
    {
        if (is_string($string) || is_numeric($string) ||
            (is_object($string) && method_exists($string, '__toString'))) {
            return $edit((string) $string, $delimiter);
        } elseif (is_array($string)) {
            return $edit($this->joinStrings($string, $delimiter), $delimiter);
        }

        throw new \LogicException('Type not access');
    }

    /**
     * @param array<string> $array
     */
    protected function arrayToCollection(array $array): StrCollection
    {
        return new StrCollection(array_map(function (string $string) {
            return new static($string);
        }, $array));
    }
}
