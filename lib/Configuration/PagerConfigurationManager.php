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

    protected function configureOptions(OptionsResolver $optionResolver): void
    {
        $optionResolver->define('contentTypes')
            ->required()
            ->allowedTypes('string[]');
        $optionResolver->define('sorts')
            ->required()
            ->allowedTypes('string[]');
        $optionResolver->define('maxPerPage')
            ->required()
            ->allowedTypes('int');
        $optionResolver->define('filters')
            ->default([])
            ->normalize(function (Options $options, $fieldsDefinitionOptions) {
                $optionResolver = new OptionsResolver();
                $this->configureFilterOptions($optionResolver);
                $filtersDefinition = [];
                foreach ($fieldsDefinitionOptions as $fieldIdentifier => $fieldDefinitionOptions) {
                    $filtersDefinition[$fieldIdentifier] = $this->resolveOptions(
                        $fieldIdentifier,
                        $optionResolver,
                        $fieldDefinitionOptions
                    );
                }
                return $filtersDefinition;
            });
    }

    protected function configureFilterOptions(OptionsResolver $optionResolver): void
    {
        $optionResolver->define('field')
            ->required()
            ->allowedTypes('string');

        $optionResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->allowedValues(...array_keys($this->searchFormGenerator->getFormTypes()));
    }
}
