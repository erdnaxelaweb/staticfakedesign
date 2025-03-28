<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentAttributeGenerator extends AbstractAttributeGenerator
{
    public function __construct(
        protected ContentGenerator $contentGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string', 'string[]');

        $optionsResolver->define('max')
            ->default(1)
            ->allowedTypes('int');
    }

    /**
     * @param string|string[] $type
     *
     * @return Content[]|Content
     */
    public function __invoke(string|array $type, int $max = 1): array|Content
    {
        if ($max === 1) {
            return ($this->contentGenerator)($type);
        }

        $contents = [];
        $count = rand(1, $max);
        for ($i = 0; $i < $count; ++$i) {
            $contents[] = ($this->contentGenerator)($type);
        }

        return $contents;
    }
}
