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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockLayoutConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BlockGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Layout;
use ErdnaxelaWeb\StaticFakeDesign\Value\LayoutZone;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlocksFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected BlockGenerator $blockGenerator,
        protected BlockLayoutConfigurationManager $blockLayoutConfigurationManager,
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('allowedTypes')
            ->required()
            ->allowedTypes('string[]');
        $optionsResolver->define('layout')
            ->required()
            ->allowedTypes('string');
    }

    public function __invoke(string $layout, array $allowedTypes): array
    {
        $layoutConfiguration = $this->blockLayoutConfigurationManager->getConfiguration($layout);

        $zones = [];
        foreach ($layoutConfiguration['zones'] as $zone) {
            $count = $this->fakerGenerator->numberBetween(1, 10);
            $blocks = [];
            for ($i = 0; $i < $count; $i++) {
                $type = $this->fakerGenerator->randomElement($allowedTypes);
                [$blockType, $blockView] = explode('/', $type) + [null, null];
                $blocks[] = ($this->blockGenerator)($blockType, $blockView);
            }

            $zones[$zone] = new LayoutZone($zone, $blocks);
        }

        return [
            "layout" => new Layout($layoutConfiguration['template'], $zones, $layoutConfiguration['sections']),
            "zones" => $zones,
        ];
    }
}
