<?php

namespace ArtARTs36\Str\Template;

class MatchTemplateResult
{
    /** @var bool */
    public $matched;

    public function __construct(
        bool $matched
    ) {
        $this->matched = $matched;
    }
}
