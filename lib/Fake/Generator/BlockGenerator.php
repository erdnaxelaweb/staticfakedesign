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
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockAttributeDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\AttributeGeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\AttributeGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use ErdnaxelaWeb\StaticFakeDesign\Value\BlockAttributesCollection;
use InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockGenerator extends AbstractGenerator
{
    public function __construct(
        protected DefinitionManager $definitionManager,
        protected AttributeGeneratorRegistry $attributeGeneratorRegistry,
        FakerGenerator $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(string $type, ?string $view = null): Block
    {
        $configuration = $this->definitionManager->getDefinition(BlockDefinition::class, $type);
        $views = $configuration->getViews();
        $view = $view ?? $this->fakerGenerator->randomElement(array_keys($views));
        return Block::createLazyGhost(function (Block $instance) use ($type, $configuration, $view) {
            $instance->__construct(
                $this->fakerGenerator->randomNumber(),
                $this->fakerGenerator->sentence(),
                $type,
                $view,
                null,
                null,
                null,
                null,
                true,
                $this->generateAttributeValue($configuration->getAttributes(), $configuration->getModels())
            );
        });
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('identifier')
            ->required()
            ->allowedTypes('string')
            ->info('Identifier of the block to generate. See erdnaxelaweb.static_fake_design.block_definition');
    }

    /**
     * @param array<string, BlockAttributeDefinition> $attributesDefinitions
     * @param array<mixed>                            $models
     */
    protected function generateAttributeValue(
        array $attributesDefinitions,
        array $models = []
    ): BlockAttributesCollection {
        $model = $this->fakerGenerator->randomElement($models);

        $attributesCollection = new BlockAttributesCollection();
        foreach ($attributesDefinitions as $attributeIdentifier => $attributeDefinition) {
            $fieldValue = $attributeDefinition->getValue() ?? ($model[$attributeIdentifier] ?? null);
            $required = $attributeDefinition->isRequired();
            $type = $attributeDefinition->getType();
            $options = $attributeDefinition->getOptions();

            try {
                $generator = $this->getAttributeGenerator($type);
                if (!$fieldValue && is_callable($generator)) {
                    $fieldValue = ($required || $this->fakerGenerator->boolean()) ? $generator(...$options) : null;
                } else {
                    $fieldValue = $generator->getForcedValue($fieldValue);
                }
            } catch (InvalidArgumentException $e) {
                $fieldValue = $e->getMessage();
            }

            $attributesCollection->set($attributeIdentifier, $fieldValue);
        }
        return $attributesCollection;
    }

    protected function getAttributeGenerator(string $type): AttributeGeneratorInterface
    {
        return $this->attributeGeneratorRegistry->getGenerator($type);
    }
}
