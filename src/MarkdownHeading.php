<?php

namespace ArtARTs36\Str;

class MarkdownHeading
{
    /** @var string */
    public $title;

    /** @var int */
    public $level;

    public function __construct(
        string $title,
        int $level
    ) {
        $this->title = $title;
        $this->level = $level;
    }
}
