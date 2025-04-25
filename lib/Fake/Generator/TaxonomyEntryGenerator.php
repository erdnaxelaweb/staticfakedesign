<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class TaxonomyEntryGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected DefinitionManager $definitionManager,
        FakerGenerator              $fakerGenerator,
        FieldGeneratorRegistry      $fieldGeneratorRegistry
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    public function __invoke(string $type): TaxonomyEntry
    {
        $configuration = $this->definitionManager->getDefinition(TaxonomyEntryDefinition::class, $type);

        $baseProperties = [
            'type' => $type,
            'languageCode' => ['eng-GB', 'fre-FR'],
            'mainLanguageCode' => 'eng-GB',
            'alwaysAvailable' => true,
        ];
        $skippedProperties = array_combine(
            array_keys($baseProperties),
            array_fill(0, count($baseProperties), true)
        );
        $initializers = [
            'id' => function () {
                return $this->fakerGenerator->randomNumber();
            },
            'name' => function () {
                return $this->fakerGenerator->sentence();
            },
            'creationDate' => function () {
                return $this->fakerGenerator->dateTime();
            },
            'modificationDate' => function () {
                return $this->fakerGenerator->dateTime();
            },
            'fields' => function (TaxonomyEntry $instance) use ($configuration) {
                return $this->generateFieldsValue(
                    $instance,
                    $configuration->getFields(),
                    $configuration->getModels()
                );
            },
            'identifier' => function () {
                return $this->fakerGenerator->word();
            },
        ];

        $instance = Instantiator::instantiate(TaxonomyEntry::class, $baseProperties);
        return TaxonomyEntry::createLazyGhost($initializers, $skippedProperties, $instance);
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
}
