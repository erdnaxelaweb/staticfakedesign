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

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class BlockLayoutSectionDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function configureOptions(OptionsResolver $optionsResolver, array $options): void
    {
        parent::configureOptions($optionsResolver, $options);
        $optionsResolver->define('template')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('blocks')
            ->default([])
            ->allowedTypes('array');
    }

    public function fromHash(array $hash): BlockLayoutSectionDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(BlockLayoutSectionDefinition::class, [
            'identifier' => $hash['identifier'],
        ]), $hash['hash']);
    }

    /**
     * @param BlockLayoutSectionDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'template' => $definition->getTemplate(),
                'blocks' => $definition->getBlocksIdentifier(),
            ],
        ];
    }
}
