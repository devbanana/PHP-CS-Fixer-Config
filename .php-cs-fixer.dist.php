<?php

declare(strict_types=1);

/*
 * This file is part of the devbanana/php-cs-fixer-config package.
 *
 * (c) Brandon Olivares <programmer2188@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Devbanana\FixerConfig\Configurator;
use Devbanana\FixerConfig\PhpVersion;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->append([
        __FILE__,
    ])
;

$header = <<<'EOF'
    This file is part of the devbanana/php-cs-fixer-config package.

    (c) Brandon Olivares <programmer2188@gmail.com>

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    EOF;

return Configurator::fromPhpVersion(PhpVersion::PHP_80())
    ->withRiskyRulesEnabled()
    ->withAddedRules([
        'header_comment' => [
            'header' => $header,
        ],
    ])
    ->fixerConfig()
    ->setFinder($finder)
;
