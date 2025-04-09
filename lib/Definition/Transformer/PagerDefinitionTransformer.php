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
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class PagerDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected PagerFilterDefinitionTransformer $pagerFilterDefinitionTransformer,
        protected PagerSortDefinitionTransformer   $pagerSortDefinitionTransformer
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('contentTypes')
            ->required()
            ->allowedTypes('string[]');

        $optionsResolver->define('excludedContentTypes')
            ->default([])
            ->allowedTypes('string[]');

        $optionsResolver->define('sorts')
            ->default([])
            ->allowedTypes('array')
            ->normalize(function (Options $options, $pagerSortDefinitionOptions) {
                foreach ($pagerSortDefinitionOptions as $pagerSortDefinitionIdentifier => $pagerSortDefinitionOption) {
                    $optionsResolver = new OptionsResolver();
                    $this->pagerSortDefinitionTransformer->configureOptions($optionsResolver, $pagerSortDefinitionOption);
                    try {
                        $pagerSortDefinitionOptions[$pagerSortDefinitionIdentifier] = $optionsResolver->resolve($pagerSortDefinitionOption);
                    } catch (UndefinedOptionsException|MissingOptionsException|InvalidOptionsException $exception) {
                        $exceptionClass = get_class($exception);
                        throw new $exceptionClass(
                            sprintf('[sorts] [%s] %s', $pagerSortDefinitionIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    }
                }
                return $pagerSortDefinitionOptions;
            });

        $optionsResolver->define('maxPerPage')
            ->required()
            ->allowedTypes('int');

        $optionsResolver->define('headlineCount')
            ->default(0)
            ->allowedTypes('int');

        $optionsResolver->define('filters')
            ->default([])
            ->allowedTypes('array')
            ->normalize(function (Options $options, $pagerFilterDefinitionOptions) {
                foreach ($pagerFilterDefinitionOptions as $pagerFilterDefinitionIdentifier => $pagerFilterDefinitionOption) {
                    $optionsResolver = new OptionsResolver();
                    $this->pagerFilterDefinitionTransformer->configureOptions($optionsResolver, $pagerFilterDefinitionOption);
                    try {
                        $pagerFilterDefinitionOptions[$pagerFilterDefinitionIdentifier] = $optionsResolver->resolve($pagerFilterDefinitionOption);
                    } catch (UndefinedOptionsException|MissingOptionsException|InvalidOptionsException $exception) {
                        $exceptionClass = get_class($exception);
                        throw new $exceptionClass(
                            sprintf('[filters] [%s] %s', $pagerFilterDefinitionIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    }
                }
                return $pagerFilterDefinitionOptions;
            });
    }

    public function fromHash(array $hash): PagerDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(PagerDefinition::class, [
            "identifier" => $hash['identifier'],
        ]), $hash['hash']);
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
}
