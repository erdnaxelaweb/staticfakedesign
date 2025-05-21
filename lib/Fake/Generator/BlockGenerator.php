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
use ErdnaxelaWeb\StaticFakeDesign\Value\LazyValue;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

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

        $baseProperties = [
            'type' => $type,
            'view' => $view,
            'class' => null,
            'style' => null,
            'since' => null,
            'till' => null,
            'isVisible' => true,
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
            'attributes' => function (Block $instance) use ($configuration) {
                return $this->generateAttributeValue(
                    $instance,
                    $configuration->getAttributes(),
                    $configuration->getModels()
                );
            },
        ];

        $instance = Instantiator::instantiate(Block::class, $baseProperties);
        return Block::createLazyGhost($initializers, $skippedProperties, $instance);
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
        Block $block,
        array $attributesDefinitions,
        array $models = []
    ): BlockAttributesCollection {
        $model = $this->fakerGenerator->randomElement($models);

        $attributesCollection = new BlockAttributesCollection();
        foreach ($attributesDefinitions as $attributeIdentifier => $attributeDefinition) {
            $attributesCollection->set(
                $attributeIdentifier,
                new LazyValue(
                    function () use ($model, $attributeDefinition, $attributeIdentifier, $block) {
                        try {
                            $generator = $this->getAttributeGenerator($attributeDefinition->getType());
                            if (!$attributeDefinition->isRequired() && $this->fakerGenerator->boolean()) {
                                return null;
                            }

                            $fieldValue = $attributeDefinition->getValue();
                            if ($model && array_key_exists($attributeIdentifier, $model)) {
                                return $generator->getForcedValue($model[$attributeIdentifier]);
                            }

                            if (!$fieldValue && is_callable($generator)) {
                                $options = $attributeDefinition->getOptions();
                                $reflectionFunction = new ReflectionClass($generator);
                                foreach ($reflectionFunction->getMethod('__invoke')->getParameters() as $parameter) {
                                    if ($parameter->getName() === 'block') {
                                        $options['block'] = $block;
                                    }
                                }
                                return $generator(...$options);
                            }
                            return $generator->getForcedValue($fieldValue);
                        } catch (InvalidArgumentException $e) {
                            return $e->getMessage();
                        }
                    }
                )
            );
        }
        return $attributesCollection;
    }

    protected function getAttributeGenerator(string $type): AttributeGeneratorInterface
    {
        return $this->attributeGeneratorRegistry->getGenerator($type);
    }
}
