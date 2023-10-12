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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\TaxonomyEntryConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\ContentFieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonomyEntryGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected TaxonomyEntryConfigurationManager $taxonomyEntryConfigurationManager,
        FakerGenerator                              $fakerGenerator,
        ContentFieldGeneratorRegistry               $fieldGeneratorRegistry
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('identifier')
            ->required()
            ->allowedTypes('string')
            ->info(
                'Identifier of the taxonomy entry to generate. See erdnaxelaweb.static_fake_design.taxonomy_entry_definition'
            );
    }

    public function __invoke(string $type): TaxonomyEntry
    {
        $configuration = $this->taxonomyEntryConfigurationManager->getConfiguration($type);
        return TaxonomyEntry::createLazyGhost(function (TaxonomyEntry $instance) use ($type, $configuration) {
            $instance->__construct(
                $this->fakerGenerator->randomNumber(),
                $this->fakerGenerator->sentence(),
                $type,
                $this->fakerGenerator->dateTime(),
                $this->fakerGenerator->dateTime(),
                $this->generateFieldsValue($configuration['fields'])
            );
        });
    }
}
