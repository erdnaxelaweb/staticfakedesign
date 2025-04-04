<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\TaxonomyEntryGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonomyEntryFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected TaxonomyEntryGenerator $taxonomyEntryGenerator
    ) {
    }

    /**
     * @return TaxonomyEntry[]|TaxonomyEntry
     */
    public function __invoke(string $type, int $max = 1): array|TaxonomyEntry
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
}
