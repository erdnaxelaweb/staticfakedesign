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
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class TaxonomyEntryDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected ContentFieldDefinitionTransformer $contentFieldDefinitionTransformer
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('fields')
            ->required()
            ->allowedTypes('array')
            ->normalize(function (Options $options, $fieldDefinitionOptions) {
                foreach ($fieldDefinitionOptions as $fieldDefinitionIdentifier => $fieldDefinitionOption) {
                    $optionsResolver = new OptionsResolver();
                    $this->contentFieldDefinitionTransformer->configureOptions($optionsResolver, $fieldDefinitionOption);
                    try {
                        $fieldDefinitionOptions[$fieldDefinitionIdentifier] = $optionsResolver->resolve($fieldDefinitionOption);
                    } catch (UndefinedOptionsException|MissingOptionsException|InvalidOptionsException $exception) {
                        $exceptionClass = get_class($exception);
                        throw new $exceptionClass(
                            sprintf('[fields] [%s] %s', $fieldDefinitionIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    }
                }
                return $fieldDefinitionOptions;
            })
            ->info('Array of field definition');

        $optionsResolver->define('models')
            ->default([])
            ->allowedTypes('array');
    }

    public function fromHash(array $hash): TaxonomyEntryDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(TaxonomyEntryDefinition::class, [
            "identifier" => $hash['identifier'],
        ]), $hash['hash']);
    }

    /**
     * @param TaxonomyEntryDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'fields' => array_map(function (ContentFieldDefinition $definition) {
                    return $this->contentFieldDefinitionTransformer->toHash($definition)['hash'];
                }, $definition->getFields()),
                'models' => $definition->getModels(),
            ],
        ];
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $fields = [];
        foreach ($options['fields'] as $fieldIdentifier => $fieldHash) {
            $fields[$fieldIdentifier] = $this->contentFieldDefinitionTransformer->fromHash(
                [
                    'identifier' => $fieldIdentifier,
                    'hash' => $fieldHash,
                ]
            );
        }
        $options['fields'] = $fields;
        return parent::lazyInitialize($instance, $options);
    }
}
