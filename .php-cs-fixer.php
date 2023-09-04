<?php

$finder = PhpCsFixer\Finder::create()->in(['src', 'tests']);

return (new \PhpCsFixer\Config())
    ->setRules([
        'full_opening_tag' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'array_indentation' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=' => 'single_space',
                '=>' => null,
                '|' => null,
            ],
        ],
        '@PSR12' => true,
        'mb_str_functions'  => true,
    ])
    ->setFinder($finder);
