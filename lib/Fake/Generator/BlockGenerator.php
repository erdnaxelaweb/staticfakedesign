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
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\ContentFieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected BlockConfigurationManager $blockConfigurationManager,
        FakerGenerator                $fakerGenerator,
        ContentFieldGeneratorRegistry $fieldGeneratorRegistry
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

    public function __invoke(string $type, string $view = 'default'): Block
    {
        $configuration = $this->blockConfigurationManager->getConfiguration($type);
        return Block::createLazyGhost(function (Block $instance) use ($type, $configuration, $view) {
            $instance->__construct(
                $this->fakerGenerator->randomNumber(),
                $this->fakerGenerator->sentence(),
                $type,
                $view,
                $this->fakerGenerator->dateTime(),
                $this->fakerGenerator->dateTime(),
                $this->generateFieldsValue($configuration['fields'], $configuration['models'])
            );
        });
    }
}
