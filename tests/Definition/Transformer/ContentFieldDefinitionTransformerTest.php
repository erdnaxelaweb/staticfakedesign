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
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\ContentFieldDefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use PHPUnit\Framework\TestCase;

class ContentFieldDefinitionTransformerTest extends TestCase
{
    private ContentFieldDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): ContentFieldDefinitionTransformer
    {
        return new ContentFieldDefinitionTransformer(ContentFieldGeneratorRegistryTest::getRegistry());
    }

    public function testFromHashTransformsContentFieldDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'field1',
            'hash' => [
                'required' => true,
                'type' => 'string',
                'value' => 'test',
                'options' => [
                    'maxLength' => 100,
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(ContentFieldDefinition::class, $definition);
        static::assertTrue($definition->isRequired());
        static::assertEquals('field1', $definition->getIdentifier());
        static::assertEquals('string', $definition->getType());
        static::assertEquals('test', $definition->getValue());
        self::assertEquals(100, $definition->getOptions()->get('maxLength'));
    }

    public function testToHashTransformsContentFieldDefinitionCorrectly(): void
    {
        $definition = new ContentFieldDefinition(
            'field1',
            'string',
            true,
            'test',
            new DefinitionOptions([
                'maxLength' => 100,
            ])
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'field1',
            'hash' => [
                'required' => true,
                'type' => 'string',
                'value' => 'test',
                'options' => [
                    'maxLength' => 100,
                ],
            ],
        ], $hash);
    }
}
