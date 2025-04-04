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

use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\ContentDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class ContentDefinitionTransformerTest extends TestCase
{
    private ContentDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): ContentDefinitionTransformer
    {
        return new ContentDefinitionTransformer(ContentFieldDefinitionTransformerTest::getTransformer());
    }

    public function testFromHashTransformsContentDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'content1',
            'hash' => [
                'fields' => [
                    "field1" => [
                        'required' => true,
                        'type' => 'string',
                        'value' => 'test',
                        'options' => [
                            'maxLength' => 100,
                        ],
                    ],
                ],
                'parent' => ['parent1', 'parent2'],
                'models' => [
                    'model1' => 'value1',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(ContentDefinition::class, $definition);
        static::assertCount(1, $definition->getFields());
        static::assertEquals('content1', $definition->getIdentifier());
        static::assertEquals(['parent1', 'parent2'], $definition->getParent());
        static::assertEquals([
            'model1' => 'value1',
        ], $definition->getModels());
        static::assertTrue($definition->hasField('field1'));
        static::assertInstanceOf(ContentFieldDefinition::class, $definition->getField('field1'));
    }

    public function testToHashTransformsContentDefinitionCorrectly(): void
    {
        $fieldDefinition = new ContentFieldDefinition(
            'field1',
            'string',
            true,
            'test',
            new DefinitionOptions([
                'maxLength' => 100,
            ])
        );

        $definition = new ContentDefinition(
            'content1',
            [
                'field1' => $fieldDefinition,
            ],
            ['parent1', 'parent2'],
            [
                'model1' => 'value1',
            ]
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'content1',
            'hash' => [
                'fields' => [
                    "field1" => [
                        'required' => true,
                        'type' => 'string',
                        'value' => 'test',
                        'options' => [
                            'maxLength' => 100,
                        ],
                    ],
                ],
                'parent' => ['parent1', 'parent2'],
                'models' => [
                    'model1' => 'value1',
                ],
            ],
        ], $hash);
    }
}
