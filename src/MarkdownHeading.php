<?php

namespace ArtARTs36\Str;

class MarkdownHeading
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
}
