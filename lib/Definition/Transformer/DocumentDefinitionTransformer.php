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
use ErdnaxelaWeb\StaticFakeDesign\Definition\DocumentDefinition;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class DocumentDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('source')
                        ->required()
                        ->allowedTypes('string');

        $optionsResolver->define('fields')
                        ->required()
                        ->normalize(function (Options $options, array $fields): array {
                            foreach ($fields as $key => $field) {
                                if (!is_string($key)) {
                                    throw new InvalidOptionsException(
                                        sprintf('[fields] The field identifier "%s" is expected to be a string.', $key)
                                    );
                                }
                                if (!is_string($field) && !is_array($field)) {
                                    throw new InvalidOptionsException(
                                        sprintf('[fields] The value of field "%s" is expected to be a string or string[].', $key)
                                    );
                                }
                            }

                            return $fields;
                        });
    }

    public function fromHash(array $hash): DocumentDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(DocumentDefinition::class, [
            "identifier" => $hash['identifier'],
        ]), $hash['hash']);
    }

    /**
     * @param DocumentDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'source' => $definition->getSource(),
                'fields' => $definition->getFields(),
            ],
        ];
    }
}
