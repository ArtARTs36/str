<?php

namespace ArtARTs36\Str;

use ArtARTs36\Str\Markdown\MarkdownElement;

class MarkdownHeading implements MarkdownElement
{
    /** @var Str */
    public $title;

    /** @var int */
    public $level;

    public function __construct(
        Str $title,
        int $level
    ) {
        $this->title = $title;
        $this->level = $level;
    }

    public function content(): Str
    {
        return Str::make(str_pad('#', $this->level) . ' ' . $this->title);
    }
}
