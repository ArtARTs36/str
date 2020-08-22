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

### Examples:

```php
use ArtARTs36\Str\Str;

$str = new Str("test \n test \n");

var_dump($str->chars());
var_dump($str->lines());
var_dump($str->toStudlyCaps());
var_dump($str->toCamelCase());
```
