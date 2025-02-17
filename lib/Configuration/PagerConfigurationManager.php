<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\SearchFormGenerator;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagerConfigurationManager extends AbstractConfigurationManager
{
    public function __construct(
        array $definitions,
        protected SearchFormGenerator $searchFormGenerator
    ) {
        parent::__construct($definitions);
    }

    protected function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('contentTypes')
            ->required()
            ->allowedTypes('string[]');

        $optionsResolver->define('excludedContentTypes')
            ->allowedTypes('string[]');

        $optionsResolver->define('sorts')
            ->default([])
            ->allowedTypes('array')
            ->normalize(function (Options $options, $sortsDefinitionOptions) {
                $optionsResolver = new OptionsResolver();
                $this->configureSortOptions($optionsResolver);
                $filtersDefinition = [];
                foreach ($sortsDefinitionOptions as $sortIdentifier => $sortDefinitionOptions) {
                    $filtersDefinition[$sortIdentifier] = $this->resolveOptions(
                        $sortIdentifier,
                        $optionsResolver,
                        $sortDefinitionOptions
                    );
                }
                return $filtersDefinition;
            });

        $optionsResolver->define('maxPerPage')
            ->required()
            ->allowedTypes('int');

        $optionsResolver->define('headlineCount')
            ->default(0)
            ->allowedTypes('int');

        $optionsResolver->define('filters')
            ->default([])
            ->normalize(function (Options $options, $filtersDefinitionOptions) {
                $filtersDefinition = [];
                foreach ($filtersDefinitionOptions as $fieldIdentifier => $filterDefinitionOptions) {
                    $optionsResolver = new OptionsResolver();
                    $this->configureFilterOptions($optionsResolver, $filterDefinitionOptions['type'] ?? '');

                    $filtersDefinition[$fieldIdentifier] = $this->resolveOptions(
                        $fieldIdentifier,
                        $optionsResolver,
                        $filterDefinitionOptions
                    );
                }
                return $filtersDefinition;
            });
    }

    protected function configureSortOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('options')
            ->default([])
            ->allowedTypes('array');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string');
    }

    protected function configureFilterOptions(OptionsResolver $optionsResolver, string $filterType): void
    {
        $optionsResolver->define('options')
            ->default([])
            ->allowedTypes('array');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->allowedValues(...array_keys($this->searchFormGenerator->getFormTypes()));
    }
}
