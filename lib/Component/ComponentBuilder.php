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

namespace ErdnaxelaWeb\StaticFakeDesign\Component;

use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Template;

class ComponentBuilder
{
    public function __construct(
        protected ComponentParameterTypeParser $componentParameterTypeParser
    ) {
    }

    protected function instanciate(array $componentArgs): Component
    {
        return new Component(...$componentArgs);
    }

    public function fromArray(array $rawParameters, Template $template): Component
    {
        $optionsResolver = new OptionsResolver();
        $this->configureComponentOptions($optionsResolver, $template);

        $componentArgs = $optionsResolver->resolve($rawParameters);
        $componentArgs['template'] = $template;

        return $this->instanciate($componentArgs);
    }

    protected function configureComponentOptions(OptionsResolver $optionsResolver, Template $template): void
    {
        $optionsResolver->define('name')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('description')
            ->default('')
            ->allowedTypes('string');

        $optionsResolver->define('specifications')
            ->default('')
            ->allowedTypes('string');

        $optionsResolver->define('type')
            ->default(function (Options $options) use ($template) {
                if (preg_match('#content/([^/]+)/#', $template->getTemplateName())) {
                    return 'content';
                }
                return 'default';
            })
            ->allowedTypes('string')
            ->allowedValues('default', 'content');

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
                    $parameterOptions = $parameterOptionsResolver->resolve($parameterOptions);

                    $parameterOptions['type'] = $this->componentParameterTypeParser->fromString(
                        $parameterOptions['type']
                    );

                    $parameters[$parameterName] = new ComponentParameter(
                        $parameterName,
                        $parameterOptions['label'],
                        $parameterOptions['required'],
                        $parameterOptions['type'],
                        array_key_exists('default', $parameterOptions),
                        $parameterOptions['default'] ?? null
                    );
                }
                return $parameters;
            });
    }

    protected function configureComponentParameterOptionOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('type')
            ->required()
            ->default(function (Options $options) {
                if (! isset($options['default'])) {
                    return null;
                }

                return gettype($options['default']);
            })
            ->allowedTypes('string');

        $optionsResolver->define('label')
            ->default('')
            ->allowedTypes('string');

        $optionsResolver->define('default');

        $optionsResolver->define('required')
            ->default(function (Options $options) {
                if (! isset($options['default'])) {
                    return true;
                }

                return false;
            })
            ->allowedTypes('boolean');
    }
}
