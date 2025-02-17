<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RichTextAttributeGenerator extends AbstractAttributeGenerator
{
    public function __construct(
        protected RichTextGenerator $richTextGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('maxWidth')
            ->default(10)
            ->allowedTypes('int');

        $optionsResolver->define('allowedTags')
            ->default([])
            ->allowedTypes('string[]')
            ->info(implode(', ', RichTextGenerator::ALLOWED_TAGS));
    }

    public function __invoke(int $maxWidth = 10, array $allowedTags = []): string
    {
        return ($this->richTextGenerator)($maxWidth, $allowedTags);
    }
}
