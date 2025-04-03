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

use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\TaxonomyEntryDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class TaxonomyEntryDefinitionTransformerTest extends TestCase
{
    private TaxonomyEntryDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): TaxonomyEntryDefinitionTransformer
    {
        return new TaxonomyEntryDefinitionTransformer(
            ContentFieldDefinitionTransformerTest::getTransformer()
        );
    }

    public function testFromHashTransformsTaxonomyEntryDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'taxonomy1',
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
                'models' => [
                    'model1' => 'value1',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(TaxonomyEntryDefinition::class, $definition);
        static::assertEquals('taxonomy1', $definition->getIdentifier());
        static::assertEquals([
            'model1' => 'value1',
        ], $definition->getModels());
        static::assertTrue($definition->hasField('field1'));
        static::assertInstanceOf(ContentFieldDefinition::class, $definition->getField('field1'));
    }

    public function testToHashTransformsTaxonomyEntryDefinitionCorrectly(): void
    {
        $fieldDefinition = new ContentFieldDefinition(
            "field1",
            'string',
            true,
            'test',
            new DefinitionOptions([
                'option1' => 'value1',
            ])
        );

        $definition = new TaxonomyEntryDefinition(
            "taxonomy1",
            [
                'field1' => $fieldDefinition,
            ],
            [
                'model1' => 'value1',
            ]
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'taxonomy1',
            'hash' => [
                'fields' => [
                    "field1" => [
                        'required' => true,
                        'type' => 'string',
                        'value' => 'test',
                        'options' => [
                            'option1' => 'value1',
                        ],
                    ],
                ],
                'models' => [
                    'model1' => 'value1',
                ],
            ],
        ], $hash);
    }
}
