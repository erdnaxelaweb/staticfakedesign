<?php

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\TaxonomyEntryGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonomyEntryFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected TaxonomyEntryGenerator $taxonomyEntryGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('max')
            ->default(1)
            ->allowedTypes('int');
    }

    public function __invoke(string $type, int $max = 1)
    {
        if ($max === 1) {
            return ($this->taxonomyEntryGenerator)($type);
        }

        $tags = [];
        $count = rand(1, $max);
        for ($i = 0; $i < $count; ++$i) {
            $tags[] = ($this->taxonomyEntryGenerator)($type);
        }

        return $tags;
    }
}
