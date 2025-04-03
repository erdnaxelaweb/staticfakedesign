<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use Closure;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\FormGenerator;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FormGenerator $formGenerator,
        FakerGenerator          $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    /**
     * @param array<string, array{type: string, options: array<string, mixed>}> $fields
     *
     * @return \Closure(mixed|null): \Symfony\Component\Form\FormView
     */
    public function __invoke(array $fields = [], ?string $name = null): Closure
    {
        return function ($modelData = null) use ($name, $fields) {
            return ($this->formGenerator)($fields, $name, $modelData);
        };
    }
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('fields')
            ->default([])
            ->allowedTypes('array')
            ->normalize(function (Options $options, $fieldsDefinitionOptions) {
                $optionsResolver = new OptionsResolver();
                $this->configureFieldOptions($optionsResolver);
                $definitions = [];
                foreach ($fieldsDefinitionOptions as $fieldName => $fieldDefinitionOptions) {
                    try {
                        $definitions[$fieldName] = $optionsResolver->resolve($fieldDefinitionOptions);
                    } catch (UndefinedOptionsException|MissingOptionsException|InvalidOptionsException $exception) {
                        throw new InvalidOptionsException(
                            sprintf('[%s] %s', $fieldName, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    }
                }
                return $definitions;
            });
        $optionsResolver->define('name')
            ->default(null)
            ->allowedTypes('null', 'string');
    }

    protected function configureFieldOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('options')
            ->default([])
            ->allowedTypes('array');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string');
    }
}
