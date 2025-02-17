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
            $zones[$zone] = [
                'id' => $zone,
                'blocks' => [],
            ];
            for ($i = 0; $i < $count; $i++) {
                $type = $this->fakerGenerator->randomElement($allowedTypes);
                [$blockType, $blockView] = explode('/', $type) + [null, null];
                $zones[$zone]['blocks'][] = ($this->blockGenerator)($blockType, $blockView);
            }
        }

        return [
            "layout" => $layoutConfiguration['template'],
            "zones" => $zones,
        ];
    }
}
