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

use JetBrains\PhpStorm\Immutable;
use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 */
#[Immutable]
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

    /**
     * @psalm-mutation-free
     */
    public static function PHP_72(): self
    {
        return new self(self::PHP_72);
    }

    /**
     * @psalm-mutation-free
     */
    public static function PHP_73(): self
    {
        return new self(self::PHP_73);
    }

    /**
     * @psalm-mutation-free
     */
    public static function PHP_74(): self
    {
        return new self(self::PHP_74);
    }

    /**
     * @psalm-mutation-free
     */
    public static function PHP_80(): self
    {
        return new self(self::PHP_80);
    }
}
