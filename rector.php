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

use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Set\ValueObject\DowngradeSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
    ]);

    $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_SHORT_CLASSES, false);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, true);

    $parameters->set(Option::SKIP, [
        CallUserFuncArrayToVariadicRector::class,
        PrivatizeLocalGetterToPropertyRector::class,
        RemoveUnusedPromotedPropertyRector::class,
        UnSpreadOperatorRector::class,
    ]);

    $services = $containerConfigurator->services();

    $containerConfigurator->import(SetList::CODING_STYLE);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::PRIVATIZATION);
    $containerConfigurator->import(SetList::PSR_4);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::EARLY_RETURN);

    // PHP version
    $containerConfigurator->import(SetList::PHP_71);
    $containerConfigurator->import(SetList::PHP_72);

    // Downgrade
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_72);
    $containerConfigurator->import(DowngradeSetList::PHP_80);
    $containerConfigurator->import(DowngradeSetList::PHP_74);
    $containerConfigurator->import(DowngradeSetList::PHP_73);

    $services->set(\Rector\DowngradePhp80\Rector\Class_\DowngradeAttributeToAnnotationRector::class)
        ->call('configure', [[
            \Rector\DowngradePhp80\Rector\Class_\DowngradeAttributeToAnnotationRector::ATTRIBUTE_TO_ANNOTATION => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
                new \Rector\DowngradePhp80\ValueObject\DowngradeAttributeToAnnotation('JetBrains\PhpStorm\Pure', 'psalm-pure'),
            ])
        ]]);
};
