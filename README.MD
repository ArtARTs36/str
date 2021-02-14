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

var_dump(Str::make("test")->chars());
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

var_dump(Str::make("test")->chars()); // 4
```

---

### Str::toLower():

```php
use ArtARTs36\Str\Str;

var_dump(Str::make("Test")->toLower()); // Test
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
