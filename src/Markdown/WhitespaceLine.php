<?php

namespace ArtARTs36\Str\Markdown;

use ArtARTs36\Str\Str;

class WhitespaceLine implements MarkdownElement
{
    public function content(): Str
    {
        return Str::make("\n");
    }
}
