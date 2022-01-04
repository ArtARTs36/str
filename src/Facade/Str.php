<?php

namespace ArtARTs36\Str\Facade;

use ArtARTs36\Str\Exceptions\EmptyStringNotAllowedOperation;
use ArtARTs36\Str\Support\Arr;
use ArtARTs36\Str\Support\LettersStat;
use ArtARTs36\Str\Symbol;

class Str
{
    public const DEFAULT_ENCODING = 'UTF-8';
    public const SEPARATOR_WORD = ' ';
    public const REGEX_SENTENCE = '/([^\\'. Symbol::DOT . ']*)/';

    public static function random(int $maxLength = 6): string
    {
        return random_bytes($maxLength);
    }

    public static function randomFix(int $length): string
    {
        $chars = array_map(function () {
            return chr(rand(1, 120));
        }, range(1, $length));

        return implode('', $chars);
    }

    public static function deleteUnnecessarySpaces(string $string): string
    {
        $replaced = preg_replace('/[\\s]{2,}/i', ' ', $string);

        return $replaced === null ? '' : $replaced;
    }

    public static function deleteAllLetters(string $string): string
    {
        $replaced = preg_replace('~\D+~', '', $string);

        return $replaced === null ? '' : $replaced;
    }

    public static function toInteger(string $string): int
    {
        return (int) static::match($string, '/([\+-]?\d+)([eE][\+-]?\d+)?/i');
    }

    public static function match(
        string $string,
        string $pattern,
        int $flags = 0,
        int $offset = 0,
        bool $end = true
    ): string {
        $matches = [];

        preg_match($pattern, $string, $matches, $flags, $offset);

        return $end ? end($matches) : reset($matches);
    }

    /**
     * @return array<string>
     */
    public static function usingLetters(string $string): array
    {
        return Arr::uniques(static::chars($string));
    }

    public static function length(string $string): int
    {
        return mb_strlen($string);
    }

    /**
     * @return array<string>
     */
    public static function chars(string $string): array
    {
        $chars = [];

        if (function_exists('mb_str_split')) {
            return mb_str_split($string);
        }

        for ($i = 0; $i < static::length($string); $i++) {
            $chars[] = mb_substr($string, $i, 1);
        }

        return $chars;
    }

    public static function lastSymbol(string $string): string
    {
        if (static::isEmpty($string)) {
            throw new EmptyStringNotAllowedOperation();
        }

        return $string[static::length($string) - 1];
    }

    public static function firstSymbol(string $string): string
    {
        if (static::isEmpty($string)) {
            throw new EmptyStringNotAllowedOperation();
        }

        return $string[0];
    }

    public static function shuffle(string $string): string
    {
        $chars = static::chars($string);
        shuffle($chars);

        return implode('', $chars);
    }

    public static function isEmpty(string $string): bool
    {
        return $string === '';
    }

    public static function isNotEmpty(string $string): bool
    {
        return ! static::isEmpty($string);
    }

    public static function cut(string $string, ?int $length, int $start = 0): string
    {
        return mb_strcut($string, $start, $length);
    }

    /**
     * @return array<int>
     */
    public static function getBytes(string $string): array
    {
        $unpacked = unpack('C*', $string);

        return array_values($unpacked === false ? [] : $unpacked);
    }

    public static function trim(string $string): string
    {
        return trim($string);
    }

    public static function reverse(string $string): string
    {
        return implode('', array_reverse(static::chars($string)));
    }

    public static function getNumbersCountInEnding(string $string): int
    {
        $count = 0;

        foreach (static::chars(static::reverse($string)) as $char) {
            if (is_numeric($char)) {
                $count++;
            } else {
                return $count;
            }
        }

        return $count;
    }

    /**
     * @param array<string|\Stringable> $subs
     */
    public static function delete(string $string, array $subs, bool $trim = false): string
    {
        $deleted = str_replace(array_map('strval', $subs), '', $string);

        return $trim ? trim($deleted) : $deleted;
    }

    public static function startsWith(string $haystack, string $needle): bool
    {
        return mb_strpos($haystack, $needle) === 0;
    }

    public static function endsWith(string $haystack, string $needle): bool
    {
        return mb_strpos($haystack, $needle, -\mb_strlen($needle)) !== false;
    }

    public static function upWords(string $string): string
    {
        return ucwords($string);
    }

    public static function toUpper(string $string): string
    {
        return mb_strtoupper($string, static::DEFAULT_ENCODING);
    }

    public static function getLettersStat(string $string): LettersStat
    {
        $stat = [];

        foreach (static::chars($string) as $char) {
            if (! isset($stat[$char])) {
                $stat[$char] = 0;
            }

            $stat[$char]++;
        }

        return new LettersStat($stat);
    }

    public static function isUpper(string $string): bool
    {
        return mb_strtoupper($string, static::DEFAULT_ENCODING) === $string;
    }

    public static function toLower(string $string): string
    {
        return mb_strtolower($string, static::DEFAULT_ENCODING);
    }

    public static function isLower(string $string): bool
    {
        return static::toLower($string) === $string;
    }

    /**
     * @param non-empty-string $separator
     */
    public static function slice(string $string, string $separator, int $length, int $offset = 0): string
    {
        $parts = explode($separator, $string);

        return implode($separator, array_slice($parts, $offset, $length));
    }

    /**
     * @param non-empty-string $separator
     * @return array<string>
     */
    public static function explode(string $string, string $separator): array
    {
        return explode($separator, $string);
    }

    /**
     * @return array<string>
     */
    public static function lines(string $string): array
    {
        return static::explode($string, "\n");
    }

    /**
     * @return array<int>
     */
    public static function positions(string $string, string $find, bool $ignoreCase = false): array
    {
        $my = $ignoreCase ? static::toLower($string) : $string;
        $find = $ignoreCase ? static::toLower($find) : $find;
        $positions = [];
        $last = 0;
        $length = mb_strlen($find);

        while (($last = mb_strpos($my, $find, $last)) !== false) {
            $positions[] = $last;
            $last = $last + $length;
        }

        return $positions;
    }

    public static function deleteLastLine(string $string): string
    {
        return static::implodeLines(Arr::withoutLastElement(static::lines(static::trim($string))));
    }

    /**
     * @param array<string> $lines
     */
    public static function implodeLines(array $lines): string
    {
        return static::implode("\n", $lines);
    }

    /**
     * @param array<string> $parts
     */
    public static function implode(string $separator, array $parts): string
    {
        return implode($separator, $parts);
    }

    public static function getLastLine(string $string): string
    {
        return Arr::last(static::lines($string));
    }

    /**
     * @return array<array<string>>
     */
    public static function getSequencesByRepeatSymbols(string $string): array
    {
        $prev = '';
        $lastSequence = 0;
        $sequences = [];

        foreach (static::chars($string) as $char) {
            if ($prev !== $char) {
                $lastSequence++;
            }

            $sequences[$lastSequence][] = $char;
            $prev = $char;
        }

        return array_values($sequences);
    }

    public static function deleteRepeatSymbolInEnding(string $string, string $symbol): string
    {
        if (static::lastSymbol($symbol) !== $symbol) {
            return $string;
        }

        $sequences = array_slice(static::getSequencesByRepeatSymbols($string), 0, -1);

        return implode('', array_map(function (array $part) {
            return implode('', $part);
        }, $sequences));
    }

    /**
     * @param array<string, string> $replaces
     */
    public static function replace(string $string, array $replaces): string
    {
        return str_replace(array_keys($replaces), array_values($replaces), $string);
    }

    public static function substring(string $string, int $start, int $length): string
    {
        return mb_substr($string, $start, $length, static::DEFAULT_ENCODING);
    }

    public static function contains(string $haystack, string $needle): bool
    {
        return mb_strpos($haystack, $needle) !== false;
    }

    public static function regexContains(string $haystack, string $needle): bool
    {
        $needle = static::replace($needle, ['/' => '\/']);

        return (bool) preg_match("/$needle/i", $haystack);
    }

    /**
     * @param array<\Stringable|string|int|float> $needles
     */
    public static function containsAny(string $string, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (static::contains($string, (string) $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<\Stringable|string|int|float> $needles
     */
    public static function regexContainsAny(string $string, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (static::regexContains($string, (string) $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<\Stringable|string|int|float> $needles
     */
    public static function containsAll(string $string, array $needles): bool
    {
        if (empty($needles)) {
            return false;
        }

        foreach ($needles as $needle) {
            if (! static::contains($string, (string) $needle)) {
                return false;
            }
        }

        return true;
    }

    public static function multiply(string $string, int $count, string $delimiter = ''): string
    {
        $newString = '';

        for ($i = 1; $i < $count + 1; $i++) {
            $newString .= ($i === $count) ? $string : ($string . $delimiter);
        }

        return $newString;
    }

    public static function linesCount(string $string): int
    {
        return count(static::lines($string));
    }

    public static function firstWord(string $string): string
    {
        return static::match($string, '#^([\w\-]+)#i');
    }

    public static function swapCase(string $string): string
    {
        return mb_strtolower($string) ^ mb_strtoupper($string) ^ $string;
    }

    /**
     * @return array<string>
     */
    public static function sentences(string $string): array
    {
        $matches = [];

        preg_match_all(static::REGEX_SENTENCE, $string, $matches);

        return array_values(array_filter($matches[0]));
    }

    /**
     * @return array<mixed>
     */
    public static function globalMatch(
        string $string,
        string $pattern,
        int $flags = PREG_SET_ORDER,
        int $offset = 0
    ): array {
        $matches = [];

        preg_match_all($pattern, $string, $matches, $flags, $offset);

        return $matches;
    }

    public static function toStudly(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $string)));
    }

    public static function isStudly(string $string): bool
    {
        return static::toStudly($string) === $string;
    }

    public static function toCamel(string $string): string
    {
        return lcfirst(static::toStudly($string));
    }

    public static function isCamel(string $string): bool
    {
        return static::toCamel($string) === $string;
    }


    public static function hasLine(string $string, string $needle, bool $trim = true): bool
    {
        foreach (static::lines($string) as $line) {
            $line = $trim ? static::trim($line) : $line;

            if (static::equals($needle, $line)) {
                return true;
            }
        }

        return false;
    }

    public static function equals(string $string, string $compared, bool $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            return static::toLower($string) === static::toLower($compared);
        }

        return $string === $compared;
    }

    public static function upFirstSymbol(string $string): string
    {
        $str = trim($string);

        $first = mb_strtoupper(mb_substr($str, 0, 1));

        return $first . mb_substr($str, 1);
    }

    /**
     * https://stackoverflow.com/questions/8804875/php-internal-hashcode-function
     */
    public static function hashCode(string $string): int
    {
        $hash = 0;

        foreach (static::chars($string) as $char) {
            $hash = static::overflowInteger(31 * $hash + mb_ord($char));
        }

        return $hash;
    }

    protected static function overflowInteger(int $value): int
    {
        $remainder = $value % 4294967296;

        if ($remainder > 2147483647) {
            return $remainder - 4294967296;
        } elseif ($remainder < -2147483648) {
            return $remainder + 4294967296;
        }

        return $remainder;
    }

    public static function isDigit(string $string): bool
    {
        return is_numeric($string);
    }

    public static function resize(string $string, int $length, string $lack = '0', bool $lackInStart = true): string
    {
        $selfLength = static::length($string);

        if ($selfLength === $length) {
            return $string;
        }

        if ($length > $selfLength) {
            $repeat = str_repeat($lack, $length - $selfLength);

            return $lackInStart ? ($repeat . $string) : ($string . $repeat);
        }

        return static::substring($string, 0, $length);
    }

    /**
     * @return array<string>
     */
    public static function words(string $string): array
    {
        return static::explode($string, static::SEPARATOR_WORD);
    }

    public static function toFloat(string $string): ?float
    {
        if (static::isDigit($string)) {
            return (float) $string;
        }

        $number = '';
        $input = false;

        foreach (static::chars($string) as $char) {
            if (is_numeric($char)) {
                $number .= $char;
                $input = true;
            } elseif ($input && $char === '.') {
                $number .= '.';
            } elseif ($input) {
                return (float) $number;
            }
        }

        return $number === '' ? null : (float) $number;
    }

    public static function hasUppercaseSymbols(string $string): bool
    {
        return static::toLower($string) !== $string;
    }

    public static function hasLowercaseSymbols(string $string): bool
    {
        return static::toUpper($string) !== $string;
    }

    public static function deleteLastSymbol(string $string): string
    {
        return static::substring($string, 0, -1);
    }

    public static function deleteFirstSymbol(string $string): string
    {
        return static::substring($string, 1, static::length($string));
    }

    public static function sortByChars(string $string, int $direction = SORT_ASC): string
    {
        $ords = array_map('ord', static::chars($string));

        return implode('', array_map('chr', Arr::sort($ords, $direction)));
    }

    public static function sortByWordsLengths(
        string $string,
        int $direction = SORT_ASC,
        bool $excludeDots = false
    ): string {
        $str = $excludeDots ? str_replace(Symbol::DOT, '', $string) : $string;

        $words = Arr::sort(explode(' ', $str), $direction);

        return implode(' ', $words);
    }

    public static function toSnakeCase(string $string, string $separator = '_'): string
    {
        $matches = static::globalMatch(
            $string,
            '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!',
            PREG_PATTERN_ORDER
        )[0];

        foreach ($matches as &$match) {
            $match = static::isUpper($match) ? static::toLower($match) : lcfirst($match);
        }

        return implode($separator, $matches);
    }

    /**
     * @return array<string>
     */
    public static function splitByDifferentCases(string $string): array
    {
        return static::globalMatch(
            $string,
            '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!',
            PREG_PATTERN_ORDER
        )[0] ?? [];
    }

    public static function deleteWhenEnds(string $haystack, string $needle): string
    {
        $needleLength = static::length($needle);

        if (static::length($haystack) < $needleLength) {
            return $haystack;
        }

        $pos = mb_strpos($haystack, $needle, -$needleLength);

        if ($pos === false) {
            return $haystack;
        }

        return mb_substr($haystack, 0, $pos);
    }

    /**
     * @link https://stackoverflow.com/questions/6038061/regular-expression-to-find-urls-within-a-string
     * @return array<string>
     */
    public static function findUris(string $string): array
    {
        return static::globalMatch(
            $string,
            '/(http|ftp|https):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])/i',
            PREG_PATTERN_ORDER
        )[0] ?? [];
    }
}
