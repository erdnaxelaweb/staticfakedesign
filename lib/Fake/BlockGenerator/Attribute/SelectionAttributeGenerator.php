<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectionAttributeGenerator extends AbstractAttributeGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('options')
            ->required()
            ->allowedTypes('string[]');

        $optionsResolver->define('isMultiple')
            ->default(false)
            ->allowedTypes('bool');
    }

    public function __invoke(array $options, bool $isMultiple = false): array
    {
        $count = $isMultiple ? $this->fakerGenerator->numberBetween(1, count($options)) : 1;
        return $this->fakerGenerator->randomElements($options, $count, false);
    }
}
