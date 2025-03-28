<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use Symfony\Component\OptionsResolver\OptionsResolver;

class IntegerAttributeGenerator extends AbstractAttributeGenerator
{
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

    public function __invoke(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return $this->fakerGenerator->numberBetween($min, $max);
    }
}
