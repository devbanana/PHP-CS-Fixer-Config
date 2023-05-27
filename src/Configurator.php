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

use JetBrains\PhpStorm\Pure;
use PhpCsFixer\Config;

final class Configurator
{
    private const RULES = [
        '@PhpCsFixer' => true,
        'align_multiline_comment' => [
            'comment_type' => 'all_multiline',
        ],
        'blank_line_before_statement' => [
            'statements' => [
                'case',
                'continue',
                'declare',
                'default',
                'do',
                'exit',
                'for',
                'foreach',
                'include',
                'include_once',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
            ],
        ],
        'concat_space' => ['spacing' => 'one'],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'phpunit',
            ],
        ],
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_add_missing_param_annotation' => false,
        'phpdoc_line_span' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_types_order' => [
            'sort_algorithm' => 'none',
            'null_adjustment' => 'always_last',
        ],
        'self_static_accessor' => true,
        'simplified_if_return' => true,
        'yoda_style' => false,
    ];

    private const RISKY_RULES = [
        '@PhpCsFixer:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        'date_time_immutable' => true,
        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'psr_autoloading' => true,
        'regular_callable_call' => true,
        'static_lambda' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP71_MIGRATION = [
        '@PHP71Migration' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP71_MIGRATION_RISKY = [
        '@PHP71Migration:risky' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP73_MIGRATION = [
        '@PHP73Migration' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP73_RULES = [
        'heredoc_indentation' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP74_MIGRATION = [
        '@PHP74Migration' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP74_MIGRATION_RISKY = [
        '@PHP74Migration:risky' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP74_RULES = [
        'no_null_property_initialization' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP80_MIGRATION = [
        '@PHP80Migration' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP80_MIGRATION_RISKY = [
        '@PHP80Migration:risky' => true,
    ];

    /**
     * @var array<string, bool>
     */
    private const PHP81_MIGRATION = [
        '@PHP81Migration' => true,
    ];

    private function __construct(
        private array $rules,
        private PhpVersion $phpVersion,
        private bool $risky = false
    ) {
    }

    /**
     * @psalm-mutation-free
     */
    public static function fromPhpVersion(PhpVersion $phpVersion): self
    {
        if ($phpVersion === PhpVersion::php72) {
            return new self(self::RULES + self::PHP71_MIGRATION, $phpVersion);
        }

        if ($phpVersion === PhpVersion::php73) {
            return new self(self::RULES + self::PHP73_MIGRATION + self::PHP73_RULES, $phpVersion);
        }

        if ($phpVersion === PhpVersion::php74) {
            return new self(self::RULES + self::PHP74_MIGRATION + self::PHP74_RULES, $phpVersion);
        }

        if ($phpVersion === PhpVersion::php80) {
            return new self(self::RULES + self::PHP80_MIGRATION + self::PHP74_RULES, $phpVersion);
        }

        if ($phpVersion === PhpVersion::php81) {
            return new self(self::RULES + self::PHP81_MIGRATION + self::PHP74_RULES, $phpVersion);
        }

        throw new \InvalidArgumentException('Unexpected PHP version given');
    }

    /**
     * @psalm-mutation-free
     */
    #[Pure]
    public function withAddedRules(array $rules): self
    {
        return new self($rules + $this->rules, $this->phpVersion, $this->risky);
    }

    /**
     * @psalm-mutation-free
     */
    public function withRiskyRulesEnabled(): self
    {
        if ($this->phpVersion === PhpVersion::php72) {
            return new self(
                $this->rules + self::RISKY_RULES + self::PHP71_MIGRATION_RISKY,
                $this->phpVersion,
                risky: true
            );
        }

        if ($this->phpVersion === PhpVersion::php73) {
            return new self(
                $this->rules + self::RISKY_RULES + self::PHP71_MIGRATION_RISKY,
                $this->phpVersion,
                risky: true
            );
        }

        if ($this->phpVersion === PhpVersion::php74) {
            return new self(
                $this->rules + self::RISKY_RULES + self::PHP74_MIGRATION_RISKY,
                $this->phpVersion,
                risky: true
            );
        }

        if ($this->phpVersion === PhpVersion::php80) {
            return new self(
                $this->rules + self::RISKY_RULES + self::PHP80_MIGRATION_RISKY,
                $this->phpVersion,
                risky: true
            );
        }

        if ($this->phpVersion === PhpVersion::php81) {
            return new self(
                $this->rules + self::RISKY_RULES + self::PHP80_MIGRATION_RISKY,
                $this->phpVersion,
                risky: true
            );
        }

        throw new \InvalidArgumentException('Unexpected PHP version given');
    }

    /**
     * @psalm-mutation-free
     */
    #[Pure]
    public function withRiskyRulesDisabled(): self
    {
        return new self(
            array_diff(
                $this->rules,
                self::RISKY_RULES,
                self::PHP71_MIGRATION_RISKY,
                self::PHP74_MIGRATION_RISKY,
                self::PHP80_MIGRATION_RISKY
            ),
            $this->phpVersion,
            risky: false
        );
    }

    public function fixerConfig(): Config
    {
        $rules = $this->rules;
        ksort($rules);

        $config = new Config();
        $config
            ->setIndent('    ')
            ->setLineEnding("\n")
            ->setRules($rules)
            ;

        if ($this->risky) {
            $config->setRiskyAllowed(true);
        }

        return $config;
    }
}
