<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\BlockLayoutDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class BlockLayoutDefinitionTransformerTest extends TestCase
{
    private BlockLayoutDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): BlockLayoutDefinitionTransformer
    {
        return new BlockLayoutDefinitionTransformer(BlockLayoutSectionDefinitionTransformerTest::getTransformer());
    }

    public function testFromHashTransformsBlockLayoutDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'layout1',
            'hash' => [
                'template' => 'default_template',
                'zones' => ['zone1', 'zone2'],
                'sections' => [
                    "section1" => [
                        'template' => 'default_template',
                        'blocks' => ['block_1', 'block_2'],
                    ],
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(BlockLayoutDefinition::class, $definition);
        static::assertEquals('layout1', $definition->getIdentifier());
        static::assertEquals('default_template', $definition->getTemplate());
        static::assertEquals(['zone1', 'zone2'], $definition->getZones());
        static::assertTrue($definition->hasSection('section1'));
        static::assertInstanceOf(BlockLayoutSectionDefinition::class, $definition->getSection('section1'));
    }

    public function testToHashTransformsBlockLayoutDefinitionCorrectly(): void
    {
        $sectionConfiguration = new BlockLayoutSectionDefinition(
            'section1',
            'default_template',
            ['block_1', 'block_2']
        );

        $definition = new BlockLayoutDefinition(
            'layout1',
            'default_template',
            ['zone1', 'zone2'],
            [
                'section1' => $sectionConfiguration,
            ],
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'layout1',
            'hash' => [
                'template' => 'default_template',
                'zones' => ['zone1', 'zone2'],
                'sections' => [
                    "section1" => [
                        'blocks' => ['block_1', 'block_2'],
                        'template' => 'default_template',
                    ],
                ],
            ],
        ], $hash);
    }
}
