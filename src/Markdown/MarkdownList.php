<?php

namespace ArtARTs36\Str\Markdown;

use ArtARTs36\Str\Str;
use ArtARTs36\Str\StrCollection;

class MarkdownList implements MarkdownElement
{
    /**
     * @var array<MarkdownElement>
     */
    public $items;

    /**
     * @param array<MarkdownElement> $items
     */
    public function __construct(
        array $items
    ) {
        $this->items = $items;
    }

    public function content(): Str
    {
        $collection = new StrCollection(array_map(function (MarkdownElement $element) {
            return $element->content();
        }, $this->items));

        return $collection->implodeAsLines();
    }
}
