<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\SearchFormGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class PagerFilterDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected readonly SearchFormGenerator $searchFormGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('options')
            ->default([])
            ->allowedTypes('array');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->allowedValues(...array_keys($this->searchFormGenerator->getFormTypes()));
    }

    public function fromHash(array $hash): PagerFilterDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(PagerFilterDefinition::class, [
            "identifier" => $hash['identifier'],
        ]), $hash['hash']);
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $options['options'] = new DefinitionOptions($options['options']);
        return parent::lazyInitialize($instance, $options);
    }

    /**
     * @param PagerFilterDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'type' => $definition->getType(),
                'options' => $definition->getOptions()
                    ->toArray(),
            ],
        ];
    }
}
