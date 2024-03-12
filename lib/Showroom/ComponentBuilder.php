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

namespace ErdnaxelaWeb\StaticFakeDesign\Showroom;

use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Template;

class ComponentBuilder
{
    public function fromArray(array $rawParameters, Template $template): Component
    {
        $optionsResolver = new OptionsResolver();
        $this->configureComponentOptions($optionsResolver);

        $componentArgs = $optionsResolver->resolve($rawParameters);
        $componentArgs['template'] = $template;

        return new Component(...$componentArgs);
    }

    protected function configureComponentOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('name')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('description')
            ->default('')
            ->allowedTypes('string');

        $optionsResolver->define('parameters')
            ->default([])
            ->allowedTypes('array')
            ->normalize(function (Options $options, $parameters) {
                foreach ($parameters as $parameterName => $parameterOptions) {
                    if (is_string($parameterOptions)) {
                        $parameterOptions = [
                            'type' => $parameterOptions,
                        ];
                    }
                    $parameterOptionsResolver = new OptionsResolver();
                    $this->configureComponentParameterOptionOptions($parameterOptionsResolver);

                    $parameters[$parameterName] = new ComponentParameter(
                        $parameterName,
                        $parameterOptionsResolver->resolve($parameterOptions)
                    );
                }
                return $parameters;
            });
    }

    protected function configureComponentParameterOptionOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string', 'array');

        $optionsResolver->define('label')
            ->default('')
            ->allowedTypes('string');

        $optionsResolver->define('required')
            ->default(true)
            ->allowedTypes('boolean');
    }
}