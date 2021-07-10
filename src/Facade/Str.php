<?php

namespace ArtARTs36\Str\Facade;

use ArtARTs36\Str\Str as Root;
use ArtARTs36\Str\Support\LettersStat;

/**
 * @method static bool contains($haystack, $needle)
 * @method static string multiply(string $string, int $count, string $delimiter = '')
 * @method static int count(string $string)
 * @method static int linesCount(string $string)
 * @method static Root[] lines(string $string)
 * @method static bool equals(string $one, string $two)
 * @method static string toStudlyCaps(string $string)
 * @method static bool isStudlyCaps(string $string)
 * @method static string toCamelCase(string $string)
 * @method static bool isCamelCase(string $string)
 * @method static string[] chars(string $string)
 * @method static string toUpper(string $string)
 * @method static bool isUpper(string $string)
 * @method static string toLower(string $string)
 * @method static bool isLower(string $string)
 * @method static string lastSymbol(string $string)
 * @method static string firstSymbol(string $string)
 * @method static string cut(string $string)
 * @method static array positions(string $find, bool $ignoreCase = false)
 * @method static string substring(string $string, int $start, int $length)
 * @method static string deleteLastSymbol(string $string)
 * @method static string deleteRepeatSymbolInEnding(string $string, string $symbol)
 * @method static string getSequencesByRepeatSymbols(string $string)
 * @method static string reverse(string $string)
 * @method static string append(string $string)
 * @method static string prepend(string $string)
 * @method static string testDeleteFirstSymbol(string $string)
 * @method static \Traversable getIterator(string $string)
 * @method static string delete(string $string, array $subs, bool $trim = false)
 * @method static string trim(string $string)
 * @method static Root[] words(string $string)
 * @method static bool isEmpty(string $string)
 * @method static bool isNotEmpty(string $string)
 * @method static string[] usingLetters()
 * @method static LettersStat getLettersStat()
 * @method static string upWords(string $string)
 * @method static Root[] explode(string $string, string $string, string $sep)
 * @method static string sortByChars(string $string, int $direction = SORT_ASC)
 * @method static string sortByWordsLengths(string $string, int $direction = SORT_ASC, bool $excludeDots = false)
 * @method static string upFirstSymbol(string $string)
 * @method static Root[] sentences(string $string)
 * @method static bool containsAny(string $string, string[] $needles)
 * @method static string match(string $string, string $pattern, int $flags = 0, int $offset = 0)
 * @method static Root[] globalMatch(string $string, string $pattern, int $flags = 0, int $offset = 0)
 * @method static Root replace(string $string, string[] $replaces)
 * @method static bool hasLine(string $string, string $needle, bool $trim = true)
 * @method static string appendEmptyLine(string $append)
 * @method static string appendLine(string $append, string $line)
 * @method static string deleteUnnecessarySpaces(string $string)
 * @method static string deleteAllLetters(string $string)
 * @method static int toInteger(string $string)
 * @method static float toFloat(string $string)
 * @method static int[] getBytes(string $string)
 */
class Str
{
    protected const DISALLOWED_METHODS = [
        'make',
        '__toString',
        'prepareStudlyCaps',
        'prepareCamelCase',
        'prepare',
        'createWithAppend',
        'createWithPrepend',
        'joinStrings',
    ];

    public static function __callStatic($name, $arguments)
    {
        if (in_array($name, static::DISALLOWED_METHODS) || !method_exists(Root::class, $name)) {
            throw new \BadMethodCallException();
        }

        //

        $string = $arguments[0];
        $arguments = array_slice($arguments, 1, count($arguments) - 1);

        //

        $response = Root::make($string)->$name(...$arguments);

        return $response instanceof Root ? $response->__toString() : $response;
    }
}
