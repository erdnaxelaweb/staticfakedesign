<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
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
        $optionsResolver->define('sorts')
            ->required()
            ->allowedTypes('array');
        $optionsResolver->define('maxPerPage')
            ->required()
            ->allowedTypes('int');
        $optionsResolver->define('filters')
            ->default([])
            ->normalize(function (Options $options, $fieldsDefinitionOptions) {
                $optionsResolver = new OptionsResolver();
                $this->configureFilterOptions($optionsResolver);
                $filtersDefinition = [];
                foreach ($fieldsDefinitionOptions as $fieldIdentifier => $fieldDefinitionOptions) {
                    $filtersDefinition[$fieldIdentifier] = $this->resolveOptions(
                        $fieldIdentifier,
                        $optionsResolver,
                        $fieldDefinitionOptions
                    );
                }
                return $filtersDefinition;
            });
    }

    protected function configureFilterOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('field')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->allowedValues(...array_keys($this->searchFormGenerator->getFormTypes()));

        $optionsResolver->define('isMultiple')
            ->default(false)
            ->allowedTypes('bool');
    }
}
