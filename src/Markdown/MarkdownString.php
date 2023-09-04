<?php

namespace ArtARTs36\Str\Markdown;

use ArtARTs36\Str\Str;

class MarkdownString implements MarkdownElement
{
    /** @var Str */
    private $str;

    public function __construct(
        Str $str
    ) {
        $this->str = $str;
    }

    public function content(): Str
    {
        return $this->str;
    }
}
