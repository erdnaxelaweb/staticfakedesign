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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BlockGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Layout;
use ErdnaxelaWeb\StaticFakeDesign\Value\LayoutZone;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlocksFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected BlockGenerator    $blockGenerator,
        protected DefinitionManager $definitionManager,
        FakerGenerator              $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
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

    /**
     * @param array<string> $allowedTypes
     *
     * @return array{layout: Layout, zones: array<string, LayoutZone>}
     */
    public function __invoke(string $layout, array $allowedTypes): array
    {
        $layoutConfiguration = $this->definitionManager->getDefinition(BlockLayoutDefinition::class, $layout);

        $zones = [];
        foreach ($layoutConfiguration->getZones() as $zone) {
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
            "layout" => new Layout($layoutConfiguration->getTemplate(), $zones, $layoutConfiguration->getSections()),
            "zones" => $zones,
        ];
    }
}
