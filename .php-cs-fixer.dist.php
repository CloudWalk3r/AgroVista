<?php

/**
 * PHP-CS-Fixer configuration for AgroVista.
 *
 * Install:  composer require --dev friendsofphp/php-cs-fixer
 * Dry run:  vendor/bin/php-cs-fixer fix --dry-run --diff
 * Apply:    vendor/bin/php-cs-fixer fix
 *
 * NOTE: This project has NOT been mass-reformatted. Run the fixer intentionally
 * on files you are already editing to avoid noisy, unrelated diffs.
 */

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('assets')
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
        'no_trailing_whitespace' => true,
        'blank_line_after_opening_tag' => true,
    ])
    ->setFinder($finder);
