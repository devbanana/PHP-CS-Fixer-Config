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

use PhpCsFixer\Config;

final class Configurator
{
    private const RULES = [
        '@Symfony' => true,
        'align_multiline_comment' => [
            'comment_type' => 'all_multiline',
        ],
        'array_indentation' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'case',
                'declare',
                'default',
                'do',
                'for',
                'foreach',
                'if',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
                'yield_from',
            ],
        ],
        'concat_space' => ['spacing' => 'one'],
        'escape_implicit_backslashes' => [
            'single_quoted' => true,
            'double_quoted' => true,
            'heredoc_syntax' => true,
        ],
        'explicit_indirect_variable' => true,
        'heredoc_to_nowdoc' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        'no_superfluous_elseif' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public_static',
                'property_public',
                'property_protected_static',
                'property_protected',
                'property_private_static',
                'property_private',
                'construct',
                'destruct',
                'phpunit',
                'method_public_abstract_static',
                'method_public_static',
                'method_public_abstract',
                'magic',
                'method_public',
                'method_protected_abstract_static',
                'method_protected_static',
                'method_protected_abstract',
                'method_protected',
                'method_private_static',
                'method_private',
            ],
        ],
        'phpdoc_line_span' => true,
        'phpdoc_order' => true,
        'phpdoc_order_by_value' => [
            'annotations' => [
                'covers',
                'dataProvider',
                'group',
                'property',
                'property-read',
                'property-write',
                'throws',
            ],
        ],
        'return_assignment' => true,
        'self_static_accessor' => true,
        'simplified_if_return' => true,
        'single_line_throw' => false,
        'yoda_style' => false,
    ];

    /**
     * @var array<string, bool|mixed[]>
     */
    private const RISKY_RULES = [
        '@Symfony:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        'date_time_immutable' => true,
        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'php_unit_strict' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'psr_autoloading' => true,
        'static_lambda' => true,
        'strict_comparison' => true,
        'strict_param' => true,
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
    private const PHP73_MIGRATION_RISKY = [
        '@PHP73Migration:risky' => true,
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
     * @var array<string, bool|mixed[]>
     */
    private $rules = [];
    /**
     * @var PhpVersion
     */
    private $phpVersion;
    /**
     * @var bool
     */
    private $risky = false;

    /**
     * @param array<string, bool|mixed[]> $rules
     */
    private function __construct(array $rules, PhpVersion $phpVersion, bool $risky = false)
    {
        $this->rules = $rules;
        $this->phpVersion = $phpVersion;
        $this->risky = $risky;
    }

    public static function fromPhpVersion(PhpVersion $phpVersion): self
    {
        if ($phpVersion->equals(PhpVersion::PHP_72())) {
            return new self(self::RULES + self::PHP71_MIGRATION, $phpVersion);
        }

        if ($phpVersion->equals(PhpVersion::PHP_73())) {
            return new self(self::RULES + self::PHP73_MIGRATION + self::PHP73_RULES, $phpVersion);
        }

        if ($phpVersion->equals(PhpVersion::PHP_74())) {
            return new self(self::RULES + self::PHP74_MIGRATION + self::PHP74_RULES, $phpVersion);
        }

        if ($phpVersion->equals(PhpVersion::PHP_80())) {
            return new self(self::RULES + self::PHP80_MIGRATION, $phpVersion);
        }

        throw new \InvalidArgumentException('Unexpected PHP version given');
    }

    /**
     * @param array<string, bool|mixed[]> $rules
     */
    public function withAddedRules(array $rules): self
    {
        return new self($rules + $this->rules, $this->phpVersion, $this->risky);
    }

    public function withRiskyRulesEnabled(): self
    {
        if ($this->phpVersion->equals(PhpVersion::PHP_72())) {
            return new self($this->rules + self::RISKY_RULES + self::PHP71_MIGRATION_RISKY, $this->phpVersion, true);
        }

        if ($this->phpVersion->equals(PhpVersion::PHP_73())) {
            return new self($this->rules + self::RISKY_RULES + self::PHP73_MIGRATION_RISKY, $this->phpVersion, true);
        }

        if ($this->phpVersion->equals(PhpVersion::PHP_74())) {
            return new self($this->rules + self::RISKY_RULES + self::PHP74_MIGRATION_RISKY, $this->phpVersion, true);
        }

        if ($this->phpVersion->equals(PhpVersion::PHP_80())) {
            return new self($this->rules + self::RISKY_RULES + self::PHP80_MIGRATION_RISKY, $this->phpVersion, true);
        }

        throw new \InvalidArgumentException('Unexpected PHP version given');
    }

    public function withRiskyRulesDisabled(): self
    {
        return new self(
            array_diff(
                $this->rules,
                self::RISKY_RULES,
                self::PHP71_MIGRATION_RISKY,
                self::PHP73_MIGRATION_RISKY,
                self::PHP74_MIGRATION_RISKY,
                self::PHP80_MIGRATION_RISKY
            ),
            $this->phpVersion,
            false
        );
    }

    public function fixerConfig(): Config
    {
        ksort($this->rules);

        $config = new Config();
        $config
            ->setIndent('    ')
            ->setLineEnding("\n")
            ->setRules($this->rules)
            ;

        if ($this->risky) {
            $config->setRiskyAllowed(true);
        }

        return $config;
    }
}
