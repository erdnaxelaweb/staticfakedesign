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

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\BlockLayoutSectionDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class BlockLayoutSectionDefinitionTransformerTest extends TestCase
{
    private BlockLayoutSectionDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): BlockLayoutSectionDefinitionTransformer
    {
        return new BlockLayoutSectionDefinitionTransformer();
    }

    public function testFromHashTransformsBlockLayoutSectionDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'section1',
            'hash' => [
                'template' => 'default_template',
                'blocks' => ['block_1', 'block_2'],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(BlockLayoutSectionDefinition::class, $definition);
        static::assertEquals('section1', $definition->getIdentifier());
        static::assertEquals('default_template', $definition->getTemplate());
        static::assertEquals(['block_1', 'block_2'], $definition->getBlocksIdentifier());
    }

    public function testToHashTransformsBlockLayoutSectionDefinitionCorrectly(): void
    {
        $definition = new BlockLayoutSectionDefinition('section1', 'default_template', ['block_1', 'block_2']);

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'section1',
            'hash' => [
                'template' => 'default_template',
                'blocks' => ['block_1', 'block_2'],
            ],
        ], $hash);
    }
}
