<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Exception\ConfigurationNotFoundException;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\ContentFieldGeneratorRegistry;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentConfigurationManager
{
    protected array $definitions;

    public function __construct(
        array                                   $definitions,
        protected ContentFieldGeneratorRegistry $contentFieldGeneratorRegistry
    ) {
        foreach ($definitions as $type => $definition) {
            $this->registerConfiguration($type, $definition);
        }
    }

    protected function configureFieldOptions(OptionsResolver $optionResolver): void
    {
        $optionResolver->define('required')
            ->default(false)
            ->allowedTypes('bool')
            ->info('Tell if field is required or not');
        $optionResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->info('Field type');

        $optionResolver->define('options')
            ->default([])
            ->normalize(function (Options $options, $fieldDefinitionOptions) {
                $optionResolver = new OptionsResolver();
                $fieldGenerator = $this->contentFieldGeneratorRegistry->getGenerator($options['type']);
                $fieldGenerator->configureOptions($optionResolver);
                return $optionResolver->resolve($fieldDefinitionOptions);
            })
            ->allowedTypes('array')
            ->info('Options to pass to the field type generator');
    }

    protected function configureOptions(OptionsResolver $optionResolver): void
    {
        $optionResolver->define('fields')
            ->required()
            ->allowedTypes()
            ->normalize(function (Options $options, $fieldsDefinitionOptions) {
                $optionResolver = new OptionsResolver();
                $this->configureFieldOptions($optionResolver);
                $fieldsDefinition = [];
                foreach ($fieldsDefinitionOptions as $fieldIdentifier => $fieldDefinitionOptions) {
                    try {
                        $fieldsDefinition[$fieldIdentifier] = $optionResolver->resolve($fieldDefinitionOptions);
                    } catch (UndefinedOptionsException $exception) {
                        throw new UndefinedOptionsException(
                            sprintf('[%s] %s', $fieldIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    } catch (MissingOptionsException $exception) {
                        throw new MissingOptionsException(
                            sprintf('[%s] %s', $fieldIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    } catch (InvalidOptionsException $exception) {
                        throw new InvalidOptionsException(
                            sprintf('[%s] %s', $fieldIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    }
                }
                return $fieldsDefinition;
            })
            ->info('Array of field definition');
        $optionResolver->define('parent')
            ->default([])
            ->allowedTypes('string[]')
            ->info('Array of possible parents type');
    }

    public function registerConfiguration(string $type, array $definition): void
    {
        $this->definitions[$type] = $definition;
    }

    public function getConfiguration(string $type): array
    {
        if (! isset($this->definitions[$type])) {
            throw new ConfigurationNotFoundException($type);
        }
        $optionResolver = new OptionsResolver();
        $this->configureOptions($optionResolver);
        try {
            return $optionResolver->resolve($this->definitions[$type]);
        } catch (UndefinedOptionsException $exception) {
            throw new UndefinedOptionsException(
                sprintf('[%s] %s', $type, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        } catch (MissingOptionsException $exception) {
            throw new MissingOptionsException(
                sprintf('[%s] %s', $type, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        } catch (InvalidOptionsException $exception) {
            throw new InvalidOptionsException(
                sprintf('[%s] %s', $type, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }
}
