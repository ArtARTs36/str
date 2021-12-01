Str
----

![PHP Composer](https://github.com/ArtARTs36/str/workflows/Testing/badge.svg?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
<a href="https://poser.pugx.org/artarts36/str/d/total.svg">
    <img src="https://poser.pugx.org/artarts36/str/d/total.svg" alt="Total Downloads">
</a>

----

### Installation:

`composer require artarts36/str`

---

### Str::chars():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make("Водка")->chars());
//array(5) {
//  [0] =>
//  string(2) "В"
//  [1] =>
//  string(2) "о"
//  [2] =>
//  string(2) "д"
//  [3] =>
//  string(2) "к"
//  [4] =>
//  string(2) "а"
//}

```

---

### Str::count():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make("test")->count()); // 4
```

---

### Str::toLower():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make("Test")->toLower()); // test
```

---

### Str::positions():

```php
use ArtARTs36\Str\Str;

$string = 'Hello Hello Hello Artem Hello Artem Hello Artem Artem';
$str = Str::make($string);

var_dump($str->positions('artem', true)); // [18, 30, 42, 48]
var_dump($str->positions('Hello')); // [0, 6, 12, 24, 36]
```

---

### Str::reverse():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Artem')->reverse()); // metrA
```

---

### Str::append():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Hello')->append('Artem', ' ')); // Hello Artem 
```

---

### Str::prepend():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Dev')->prepend('Hello', ' ')); // Hello Dev 
```

---

### Str::equals

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Dev')->equals('dev')); // false
var_dump(Str::make('Dev')->equals('Dev')); // true
```

---

### Str::deleteLastSymbol

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Dev')->deleteLastSymbol()); // De
```

---

### Str::deleteFirstSymbol

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Dev')->deleteFirstSymbol()); // ev
```

---

### Str::delete

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Test A B')->delete(['Test', 'A'])); // "  B"
var_dump(Str::make('Test A B')->delete(['Test', 'A'], true)); // "B"
```

---

### Str::trim

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('  TEST ')->trim()); // "TEST"
```

---

### Iterable

```php
use ArtARTs36\Str\Str;

foreach (Str::make('test') as $char) {
    var_dump($char);
}
// t
// e
// s
// t
```

---

### Str::words

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('TEST 123')->words()); // ['TEST', '123']
```

---

### Str::isEmpty()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('TEST 123')->isEmpty()); // false
var_dump(Str::make(' ')->isEmpty()); // true
```

---

### Str::usingLetters()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('AABBBCCC')->usingLetters());
// [A, B, C]
```

---

### Str::getLettersStat()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('AABBBCCC')->getLettersStat()->getDict());
// [A => 2, B => 3, C => 3]
```

---

### Str::upWords()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello dev')->upWords());
// "Hello Dev"
```

---

### Str::explode()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->explode('.'));
// ['Hello', 'Dev']
```

---

### Str::sortByChars()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('ABCD')->sortByChars());
// CDBA
```

---

### Str::sortByWordsLengths()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('BBB A DDDDD CCCC')->sortByWordsLengths());
// A BBB CCCC DDDDD
```

---

### Str::upFirstSymbol()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('слово')->upFirstSymbol());
// "Слово"
```
---

### Str::sentences()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->sentences());
// ['hello', 'dev']
```
---

### Str::containsAny()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->containsAny([
    'dev',
]));
// true
```

---

### Str::containsAll()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->containsAll([
    'dev',
    'hello',
]));
// true
```

---

### Str::random()

```php
use ArtARTs36\Str\Str;

var_dump(Str::random());
// random string
```

---

### Str::randomFix()

```php
use ArtARTs36\Str\Str;

var_dump(Str::randomFix(12));
// random string 12 length
```

---

### Str::shuffle()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Hello')->shuffle());
```

---

### Str::getBytes()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->getBytes());
// [72, 101, 108, 108, 111]
```

---

### Str::startsWith()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->startsWith('hello'));
// true
```

---

### Str::endsWith()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('hello.dev')->endsWith('dev'));
// true
```

---

### Str::hashCode()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Hello')->hashCode());
// 69609650
```

---

### Str::isDigit()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('123')->isDigit());
// true
```
---

### Str::resize()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Test')->resize(5));
// 0Test
```

---

### Str::swapCase()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Test')->swapCase());
// tEST
```

### Str::hasUppercaseSymbols()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Artem')->hasUppercaseSymbols()); // true
var_dump(Str::make('artem')->hasUppercaseSymbols()); // false
```

### Str::hasLowercaseSymbols()

```php
use ArtARTs36\Str\Str;

var_dump(Str::make('Artem')->hasLowercaseSymbols()); // true
var_dump(Str::make('ARTEM')->hasLowercaseSymbols()); // false
```
