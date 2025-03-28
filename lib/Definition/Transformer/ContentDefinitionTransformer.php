<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class ContentDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected ContentFieldDefinitionTransformer $contentFieldDefinitionTransformer
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('fields')
            ->required()
            ->allowedTypes('array')
            ->info('Array of field definition');

        $optionsResolver->define('parent')
            ->default([])
            ->allowedTypes('string[]')
            ->info('Array of possible parents type');

        $optionsResolver->define('models')
            ->default([])
            ->allowedTypes('array');
    }

    public function fromHash(array $hash): ContentDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(ContentDefinition::class, [
            'identifier' => $hash['identifier'],
        ]), $hash['hash']);
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $fields = [];
        foreach ($options['fields'] as $fieldIdentifier => $fieldHash) {
            $fields[$fieldIdentifier] = $this->contentFieldDefinitionTransformer->fromHash(
                [
                    'identifier' => $fieldIdentifier,
                    'hash' => $fieldHash,
                ]
            );
        }
        $options['fields'] = $fields;
        return parent::lazyInitialize($instance, $options);
    }

    /**
     * @param ContentDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'fields' => array_map(function (ContentFieldDefinition $fieldDefinition): array {
                    return $this->contentFieldDefinitionTransformer->toHash($fieldDefinition)['hash'];
                }, $definition->getFields()),
                'parent' => $definition->getParent(),
                'models' => $definition->getModels(),
            ],
        ];
    }
}
