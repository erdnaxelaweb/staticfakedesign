<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class TaxonomyEntryDefinitionTransformer extends AbstractDefinitionTransformer
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

        $optionsResolver->define('models')
            ->default([])
            ->allowedTypes('array');
    }

    public function fromHash(array $hash): TaxonomyEntryDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(TaxonomyEntryDefinition::class, [
            "identifier" => $hash['identifier'],
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
     * @param TaxonomyEntryDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'fields' => array_map(function (ContentFieldDefinition $definition) {
                    return $this->contentFieldDefinitionTransformer->toHash($definition)['hash'];
                }, $definition->getFields()),
                'models' => $definition->getModels(),
            ],
        ];
    }
}
