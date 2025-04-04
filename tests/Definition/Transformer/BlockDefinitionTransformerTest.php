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

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockAttributeDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\BlockDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class BlockDefinitionTransformerTest extends TestCase
{
    private BlockDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): BlockDefinitionTransformer
    {
        return new BlockDefinitionTransformer(BlockAttributeDefinitionTransformerTest::getTransformer());
    }

    public function testFromHashTransformsBlockDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'block1',
            'hash' => [
                'attributes' => [
                    "attribute1" => [
                        'required' => true,
                        'type' => 'string',
                        'value' => 'test',
                        'options' => [
                            'maxLength' => 100,
                        ],
                    ],
                ],
                'views' => [
                    'view1' => 'template1',
                    'view2' => 'template2',
                ],
                'models' => [
                    'model1' => 'value1',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);
        static::assertInstanceOf(BlockDefinition::class, $definition);
        static::assertCount(1, $definition->getAttributes());
        static::assertEquals('block1', $definition->getIdentifier());
        static::assertTrue($definition->hasView('view1'));
        static::assertEquals('template1', $definition->getView('view1'));
        static::assertEquals([
            'model1' => 'value1',
        ], $definition->getModels());
        static::assertTrue($definition->hasAttribute('attribute1'));
        static::assertInstanceOf(BlockAttributeDefinition::class, $definition->getAttribute('attribute1'));
    }

    public function testToHashTransformsBlockDefinitionCorrectly(): void
    {
        $attributeDefinition = new BlockAttributeDefinition(
            'attribute1',
            'string',
            true,
            'test',
            new DefinitionOptions(
                [
                    'maxLength' => 100,
                ]
            )
        );

        $definition = new BlockDefinition(
            'block1',
            [
                'attribute1' => $attributeDefinition,
            ],
            [
                'view1' => 'template1',
                'view2' => 'template2',
            ],
            [
                'model1' => 'value1',
            ]
        );

        $hash = $this->transformer->toHash($definition);
        static::assertEquals([
            'identifier' => 'block1',
            'hash' => [
                'attributes' => [
                    "attribute1" => [
                        'required' => true,
                        'type' => 'string',
                        'value' => 'test',
                        'options' => [
                            'maxLength' => 100,
                        ],
                    ],
                ],
                'views' => [
                    'view1' => 'template1',
                    'view2' => 'template2',
                ],
                'models' => [
                    'model1' => 'value1',
                ],
            ],
        ], $hash);
    }
}
