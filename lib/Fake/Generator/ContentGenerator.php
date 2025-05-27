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
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentRelation;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentRelationsIterator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class ContentGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected DefinitionManager $definitionManager,
        protected BreadcrumbGenerator $breadcrumbGenerator,
        FieldGeneratorRegistry $fieldGeneratorRegistry,
        FakerGenerator $fakerGenerator,
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    /**
     * @param string|string[] $type
     */
    public function __invoke(array|string $type): Content
    {
        if (is_array($type)) {
            $type = $this->fakerGenerator->randomElement($type);
        }
        $configuration = $this->definitionManager->getDefinition(ContentDefinition::class, $type);

        $baseProperties = [
            'type' => $type,
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
            'fields' => function (Content $instance) use ($configuration) {
                return $this->generateFieldsValue(
                    $instance,
                    $configuration->getFields(),
                    $configuration->getModels()
                );
            },
            'url' => function () {
                return $this->fakerGenerator->url();
            },
            'breadcrumb' => function () {
                return ($this->breadcrumbGenerator)();
            },
            'reverseRelations' => function (Content $instance) {
                $contentDefinitions = $this->definitionManager->getDefinitionsByType(ContentDefinition::class);
                $possibleRelations = [];
                foreach ($contentDefinitions as $contentDefinition) {
                    $relations = $contentDefinition->getRelations();
                    foreach ($relations as $relationDefinition) {
                        if (in_array($instance->type, $relationDefinition->getDestinationContentType(), true)) {
                            $possibleRelations[] = $relationDefinition;
                        }
                    }
                }

                return new ContentRelationsIterator(
                    function () use ($instance, $possibleRelations): ContentRelation {
                        /** @var \ErdnaxelaWeb\StaticFakeDesign\Definition\ContentRelationDefinition $relationDefinition */
                        $relationDefinition = $this->fakerGenerator->randomElement($possibleRelations);
                        return new ContentRelation(
                            ($this)($relationDefinition->getSourceContentTypes()),
                            $instance,
                            $relationDefinition->getType(),
                            $relationDefinition->getSourceFieldIdentifier()
                        );
                    },
                    $this->fakerGenerator->numberBetween(1, 10)
                );
            },
        ];

        $instance = Instantiator::instantiate(Content::class, $baseProperties);
        return Content::createLazyGhost($initializers, $skippedProperties, $instance);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string', 'string[]')
            ->info('Identifier of the content to generate. See erdnaxelaweb.static_fake_design.content_definition');
    }
}
