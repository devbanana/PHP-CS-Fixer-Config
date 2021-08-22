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

namespace Devbanana\FixerConfig;

use MyCLabs\Enum\Enum;

/**
 * @method static PhpVersion PHP_72()
 * @method static PhpVersion PHP_73()
 * @method static PhpVersion PHP_74()
 * @method static PhpVersion PHP_80()
 *
 * @extends Enum<string>
 */
final class PhpVersion extends Enum
{
    /**
     * @var string
     */
    private const PHP_72 = '7.2';
    /**
     * @var string
     */
    private const PHP_73 = '7.3';
    /**
     * @var string
     */
    private const PHP_74 = '7.4';
    /**
     * @var string
     */
    private const PHP_80 = '8.0';
}
