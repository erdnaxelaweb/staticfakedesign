<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StringAttributeGenerator extends AbstractAttributeGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);

        $optionsResolver->define('maxLength')
            ->default(100)
            ->allowedTypes('int');
    }

    public function __invoke(int $maxLength = 100): string
    {
        return $this->fakerGenerator->text($maxLength);
    }

    public function getForcedValue($value)
    {
        return is_array($value) ? $this->fakerGenerator->randomElement($value) : $value;
    }
}
