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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class BlockLayoutDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected BlockLayoutSectionDefinitionTransformer $blockLayoutSectionConfigurationTransformer
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('template')
            ->required()
            ->allowedTypes('string');

        $optionsResolver->define('zones')
            ->required()
            ->allowedTypes('array');

        $optionsResolver->define('sections')
            ->default(function (OptionsResolver $optionsResolver): void {
                $optionsResolver->setPrototype(true);
                $this->blockLayoutSectionConfigurationTransformer->configureOptions($optionsResolver);
            })
            ->allowedTypes('array')
            ->normalize(function (Options $options, array $sections): array {
                $sectionDefinitions = [];
                foreach ($sections as $sectionIdentifier => $sectionOptions) {
                    $sectionDefinitions[$sectionIdentifier] = $this->blockLayoutSectionConfigurationTransformer->fromHash(
                        [
                            'identifier' => $sectionIdentifier,
                            'hash' => $sectionOptions,
                        ]
                    );
                }
                return $sectionDefinitions;
            });
    }

    public function fromHash(array $hash): BlockLayoutDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(BlockLayoutDefinition::class, [
            'identifier' => $hash['identifier'],
        ]), $hash['hash']);
    }

    /**
     * @param BlockLayoutDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'template' => $definition->getTemplate(),
                'zones' => $definition->getZones(),
                'sections' => array_map(function (BlockLayoutSectionDefinition $section): array {
                    return $this->blockLayoutSectionConfigurationTransformer->toHash($section)['hash'];
                }, $definition->getSections()),
            ],
        ];
    }
}
