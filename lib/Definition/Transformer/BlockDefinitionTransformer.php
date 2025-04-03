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
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockAttributeDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class BlockDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected BlockAttributeDefinitionTransformer $blockAttributeDefinitionTransformer
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('attributes')
            ->required()
            ->allowedTypes('array')
            ->normalize(function (Options $options, $attributeDefinitionOptions) {
                foreach ($attributeDefinitionOptions as $attributeDefinitionIdentifier => $attributeDefinitionOption) {
                    $optionsResolver = new OptionsResolver();
                    $this->blockAttributeDefinitionTransformer->configureOptions($optionsResolver, $attributeDefinitionOption);
                    try {
                        $attributeDefinitionOptions[$attributeDefinitionIdentifier] = $optionsResolver->resolve($attributeDefinitionOption);
                    } catch (UndefinedOptionsException|MissingOptionsException|InvalidOptionsException $exception) {
                        $exceptionClass = get_class($exception);
                        throw new $exceptionClass(
                            sprintf('[attributes] [%s] %s', $attributeDefinitionIdentifier, $exception->getMessage()),
                            $exception->getCode(),
                            $exception
                        );
                    }
                }
                return $attributeDefinitionOptions;
            })
            ->info('Array of field definition');

        $optionsResolver->define('views')
            ->required()
            ->allowedTypes('string[]')
            ->normalize(function (Options $options, $views) {
                if (empty($views)) {
                    throw new InvalidOptionsException('The option "views" is expected to not be empty.');
                }
                foreach (array_keys($views) as $view) {
                    if (!is_string($view)) {
                        throw new InvalidOptionsException(
                            'The view identifier "' . $view . '" is expected to be a string.'
                        );
                    }
                }
                return $views;
            });

        $optionsResolver->define('models')
            ->default([])
            ->allowedTypes('array');
    }

    public function fromHash(array $hash): BlockDefinition
    {
        return $this->lazyFromHash(
            Instantiator::instantiate(BlockDefinition::class, [
                'identifier' => $hash['identifier'],
            ]),
            $hash['hash']
        );
    }

    /**
     * @param BlockDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'attributes' => array_map(
                    function (BlockAttributeDefinition $definition) {
                        return $this->blockAttributeDefinitionTransformer->toHash($definition)['hash'];
                    },
                    $definition->getAttributes()
                ),
                'views' => $definition->getViews(),
                'models' => $definition->getModels(),
            ],
        ];
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $attributes = [];
        foreach ($options['attributes'] as $attributeIdentifier => $attributeHash) {
            $attributes[$attributeIdentifier] = $this->blockAttributeDefinitionTransformer->fromHash(
                [
                    'identifier' => $attributeIdentifier,
                    'hash' => $attributeHash,
                ]
            );
        }
        $options['attributes'] = $attributes;
        return parent::lazyInitialize($instance, $options);
    }
}
