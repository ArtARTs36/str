<?php

namespace ArtARTs36\Str\Docs;

class Example
{
    public $class;

    public $method;

    public $arguments;

    public $result;

    public function __construct(string $class, string $method, array $arguments, $result)
    {
        $this->class = $class;
        $this->method = $method;
        $this->arguments = $arguments;
        $this->result = $result;
    }
}
