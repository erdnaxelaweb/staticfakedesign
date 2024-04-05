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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use ErdnaxelaWeb\StaticFakeDesign\Value\BlockAttributesCollection;
use ErdnaxelaWeb\StaticFakeDesign\Value\FieldsCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected BlockConfigurationManager $blockConfigurationManager,
        FakerGenerator                $fakerGenerator,
        FieldGeneratorRegistry $fieldGeneratorRegistry
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('identifier')
            ->required()
            ->allowedTypes('string')
            ->info('Identifier of the block to generate. See erdnaxelaweb.static_fake_design.block_definition');
    }

    protected function getCollection(): FieldsCollection
    {
        return new BlockAttributesCollection();
    }

    public function __invoke(string $type, ?string $view = null): Block
    {
        $configuration = $this->blockConfigurationManager->getConfiguration($type);
        $views = $configuration['views'];
        $view = $view ?? $this->fakerGenerator->randomElement(array_keys($views));
        return Block::createLazyGhost(function (Block $instance) use ($views, $type, $configuration, $view) {
            $instance->__construct(
                $this->fakerGenerator->randomNumber(),
                $this->fakerGenerator->sentence(),
                $type,
                $view,
                $this->generateFieldsValue($configuration['attributes'], $configuration['models'])
            );
        });
    }
}
