<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class PagerDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected PagerFilterDefinitionTransformer $pagerFilterDefinitionTransformer,
        protected PagerSortDefinitionTransformer   $pagerSortDefinitionTransformer
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('contentTypes')
            ->required()
            ->allowedTypes('string[]');

        $optionsResolver->define('excludedContentTypes')
            ->allowedTypes('string[]');

        $optionsResolver->define('sorts')
            ->default([])
            ->allowedTypes('array');

        $optionsResolver->define('maxPerPage')
            ->required()
            ->allowedTypes('int');

        $optionsResolver->define('headlineCount')
            ->default(0)
            ->allowedTypes('int');

        $optionsResolver->define('filters')
            ->default(function (OptionsResolver $optionsResolver) {
                $optionsResolver->setPrototype(true);
                $this->pagerFilterDefinitionTransformer->configureOptions($optionsResolver);
            })
            ->allowedTypes('array');
    }

    public function fromHash(array $hash): PagerDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(PagerDefinition::class, [
            "identifier" => $hash['identifier'],
        ]), $hash['hash']);
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $filterDefinitions = [];
        foreach ($options['filters'] as $filterDefinitionIdentifier => $filterDefinitionOption) {
            $filterDefinitions[$filterDefinitionIdentifier] = $this->pagerFilterDefinitionTransformer->fromHash(
                [
                    'identifier' => $filterDefinitionIdentifier,
                    'hash' => $filterDefinitionOption,
                ]
            );
        }
        $options['filters'] = $filterDefinitions;

        $sortDefinitions = [];
        foreach ($options['sorts'] as $sortDefinitionIdentifier => $sortDefinitionOption) {
            $sortDefinitions[$sortDefinitionIdentifier] = $this->pagerSortDefinitionTransformer->fromHash(
                [
                    'identifier' => $sortDefinitionIdentifier,
                    'hash' => $sortDefinitionOption,
                ]
            );
        }
        $options['sorts'] = $sortDefinitions;
        return parent::lazyInitialize($instance, $options);
    }

    /**
     * @param PagerDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'contentTypes' => $definition->getContentTypes(),
                'maxPerPage' => $definition->getMaxPerPage(),
                'sorts' => array_map(function (PagerSortDefinition $sortDefinition) {
                    return $this->pagerSortDefinitionTransformer->toHash($sortDefinition)['hash'];
                }, $definition->getSorts()),
                'filters' => array_map(function (PagerFilterDefinition $filterDefinition) {
                    return $this->pagerFilterDefinitionTransformer->toHash($filterDefinition)['hash'];
                }, $definition->getFilters()),
                'excludedContentTypes' => $definition->getExcludedContentTypes(),
                'headlineCount' => $definition->getHeadlineCount(),
            ],
        ];
    }
}
