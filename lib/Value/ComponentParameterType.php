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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentParameterType
{
    public function __construct(
        public string $name,
        public array $options = [],
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->options['type'];
    }

    public function getLabel()
    {
        return $this->options['label'];
    }

    public function getRequired()
    {
        return $this->options['required'];
    }

    public static function resolveOptions(array $options): array
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string', 'array');
        $optionsResolver->define('label')
            ->required()
            ->allowedTypes('string');
        $optionsResolver->define('required')
            ->default(true)
            ->allowedTypes('boolean');

        return $optionsResolver->resolve($options);
    }
}
