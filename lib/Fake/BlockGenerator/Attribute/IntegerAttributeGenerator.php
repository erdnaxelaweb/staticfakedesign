<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use Symfony\Component\OptionsResolver\OptionsResolver;

class IntegerAttributeGenerator extends AbstractAttributeGenerator
{
    public function __invoke(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return $this->fakerGenerator->numberBetween($min, $max);
    }
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('min')
            ->default(0)
            ->allowedTypes('int');

        $optionsResolver->define('max')
            ->default(PHP_INT_MAX)
            ->allowedTypes('int');
    }
}
