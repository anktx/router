<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PER-CS2.0' => true,
        '@PER-CS2.0:risky' => true,
        'declare_strict_types' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'native_constant_invocation' => true,
        'return_assignment' => false,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'php_unit_test_case_static_method_calls' => false,
    ])
    ->setFinder(
        Finder::create()
            ->exclude('vendor')
            ->in(__DIR__),
    )->setCacheFile(__DIR__ . '/.cache/php-cs-fixer.cache');
