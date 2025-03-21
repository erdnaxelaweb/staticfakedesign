<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockLayoutConfigurationManager extends AbstractConfigurationManager
{
    protected function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('template')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('zones')
            ->required()
            ->allowedTypes('array');

        $optionsResolver->define('sections')
            ->default([])
            ->allowedTypes('array');
    }
}
