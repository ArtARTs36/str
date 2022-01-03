<?php

require __DIR__ . '/../../vendor/autoload.php';

$exampleBuilder = new \ArtARTs36\Str\Docs\ExampleBuilder(
    __DIR__ . '/../../tests',
    'Test',
    'ArtARTs36\Str\Tests\\'
);

var_dump($exampleBuilder->build());
