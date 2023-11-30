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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\FormGenerator;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormFieldGenerator extends AbstractFieldGenerator
{
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
                    $definitions[$fieldName] = $this->resolveOptions(
                        $fieldName,
                        $optionsResolver,
                        $fieldDefinitionOptions
                    );
                }
                return $definitions;
            });
        $optionsResolver->define('name')
            ->default(null)
            ->allowedTypes('null', 'string');
    }

    protected function resolveOptions(string $identifier, OptionsResolver $optionsResolver, array $options)
    {
        try {
            return $optionsResolver->resolve($options);
        } catch (UndefinedOptionsException $exception) {
            throw new UndefinedOptionsException(
                sprintf('[%s] %s', $identifier, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        } catch (MissingOptionsException $exception) {
            throw new MissingOptionsException(
                sprintf('[%s] %s', $identifier, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        } catch (InvalidOptionsException $exception) {
            throw new InvalidOptionsException(
                sprintf('[%s] %s', $identifier, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
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

    public function __construct(
        protected FormGenerator $formGenerator,
        FakerGenerator $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(array $fields = [], ?string $name = null): FormView
    {
        return ($this->formGenerator)($fields, $name);
    }
}
