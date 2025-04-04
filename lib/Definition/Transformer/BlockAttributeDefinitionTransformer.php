<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockAttributeDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\AttributeGeneratorRegistry;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class BlockAttributeDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected AttributeGeneratorRegistry $attributeGeneratorRegistry
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('required')
            ->default(false)
            ->allowedTypes('bool')
            ->info('Tell if field is required or not');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->info('Field type');

        $optionsResolver->define('value')
            ->default(null)
            ->info('Forced value');

        $optionsResolver->define('options')
            ->default([])
            ->normalize(function (Options $options, $fieldDefinitionOptions) {
                $optionsResolver = new OptionsResolver();
                $attributeGenerator = $this->attributeGeneratorRegistry->getGenerator($options['type']);
                $attributeGenerator->configureOptions($optionsResolver);
                return $optionsResolver->resolve($fieldDefinitionOptions);
            })
            ->allowedTypes('array')
            ->info('Options to pass to the field type generator');
    }

    public function fromHash(array $hash): BlockAttributeDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(BlockAttributeDefinition::class, [
            'identifier' => $hash['identifier'],
        ]), $hash['hash']);
    }

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Definition\BlockAttributeDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'required' => $definition->isRequired(),
                'type' => $definition->getType(),
                'value' => $definition->getValue(),
                'options' => $definition->getOptions()
                    ->toArray(),
            ],
        ];
    }

    protected function getClassName(): string
    {
        return BlockAttributeDefinition::class;
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $options['options'] = new DefinitionOptions($options['options']);
        return parent::lazyInitialize($instance, $options);
    }
}
