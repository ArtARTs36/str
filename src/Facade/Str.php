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
 * @method static string[] usingLetters()
 * @method static LettersStat getLettersStat()
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
