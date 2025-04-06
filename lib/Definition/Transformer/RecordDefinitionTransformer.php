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

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\RecordDefinition;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class RecordDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('sources')
                        ->required()
                        ->allowedTypes('string[]')
                        ->normalize(function (Options $options, array $sources): array {
                            if (empty($sources)) {
                                throw new InvalidOptionsException(
                                    '[sources] The option "sources" is expected to not be empty.'
                                );
                            }

                            foreach (array_keys($sources) as $key) {
                                if (!is_string($key)) {
                                    throw new InvalidOptionsException(
                                        sprintf('[sources] The source identifier "%s" is expected to be a string.', $key)
                                    );
                                }
                            }

                            return $sources;
                        });

        $optionsResolver->define('attributes')
                        ->required()
                        ->allowedTypes('string[]')
                        ->normalize(function (Options $options, array $attributes): array {
                            foreach (array_keys($attributes) as $key) {
                                if (!is_string($key)) {
                                    throw new InvalidOptionsException(
                                        sprintf('[attributes] The attribute identifier "%s" is expected to be a string.', $key)
                                    );
                                }
                            }
                            if (!isset($attributes['id'])) {
                                throw new InvalidOptionsException(
                                    '[attributes] The attribute identifier id is expected to be defined.'
                                );
                            }

                            return $attributes;
                        });
    }

    public function fromHash(array $hash): RecordDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(RecordDefinition::class, [
            "identifier" => $hash['identifier'],
        ]), $hash['hash']);
    }

    /**
     * @param RecordDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'sources' => $definition->getSources(),
                'attributes' => $definition->getAttributes(),
            ],
        ];
    }
}
