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

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;

class RecordDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('sources')
                        ->required()
                        ->allowedTypes('string[]')
                        ->normalize(function (Options $options, array $sources): array {
                            $this->validateNonEmptyArray($sources, 'sources');
                            $this->validateArrayKeysAreStrings($sources, 'source');

                            return $sources;
                        });

        $optionsResolver->define('attributes')
                        ->required()
                        ->allowedTypes('string[]')
                        ->normalize(function (Options $options, array $attributes): array {
                            foreach (array_keys($attributes) as $key) {
                                if (! is_string($key)) {
                                    throw new InvalidOptionsException(
                                        sprintf('The attribute identifier "%s" is expected to be a string.', $key)
                                    );
                                }
                            }
                            if (! isset($attributes['id'])) {
                                throw new InvalidOptionsException(
                                    'The attribute identifier id is expected to be defined.'
                                );
                            }
                            $this->validateRequiredAttributeExists($attributes);

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
     * @param RecordDefinition $instance
     */
    public function toHash(DefinitionInterface $instance): array
    {
        return [
            'identifier' => $instance->getIdentifier(),
            'hash' => [
                'sources' => $instance->getSources(),
                'attributes' => $instance->getAttributes(),
            ],
        ];
    }
    
}
