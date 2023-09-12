<?php

namespace ArtARTs36\Str\Template;

class TemplatePlaceholders
{
    public const TEMPLATE_DEFAULT_REGEXES = [
        '\{word\}' => '(\w+)',
        '\{text_line\}' => '(.*)',
        '\{text_multiline\}' => '((.|\n)*)',
        '\{number\}' => '(\d+\.\d+)|(\d+)',
    ];

    /** @var array<string, string> */
    private $placeholders;

    /**
     * @param array<string, string> $placeholders
     */
    public function __construct(
        array $placeholders
    ) {
        $this->placeholders = $placeholders;
    }

    public static function default(): self
    {
        return new self(self::TEMPLATE_DEFAULT_REGEXES);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->placeholders;
    }

    public function add(string $placeholder, string $regex): self
    {
        $key = "\{$placeholder\}";

        $this->placeholders[$key] = $regex;

        return $this;
    }
}
