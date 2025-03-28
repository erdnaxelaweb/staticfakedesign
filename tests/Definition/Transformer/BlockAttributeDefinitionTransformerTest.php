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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockAttributeDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\BlockAttributeDefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\AttributeGeneratorRegistryTest;
use PHPUnit\Framework\TestCase;

class BlockAttributeDefinitionTransformerTest extends TestCase
{
    private BlockAttributeDefinitionTransformer $transformer;

    public static function getTransformer(): BlockAttributeDefinitionTransformer
    {
        return new BlockAttributeDefinitionTransformer(AttributeGeneratorRegistryTest::getRegistry());
    }

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public function testFromHashTransformsCorrectly(): void
    {
        $hash = [
            'identifier' => 'test',
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

        static::assertInstanceOf(BlockAttributeDefinition::class, $definition);
        static::assertTrue($definition->isRequired());
        static::assertEquals('string', $definition->getType());
        static::assertEquals('test', $definition->getValue());
        self::assertEquals(100, $definition->getOptions()->get('maxLength'));
    }

    public function testToHashTransformsCorrectly(): void
    {
        $definition = new BlockAttributeDefinition(
            'test',
            'string',
            true,
            'test',
            new DefinitionOptions([
                'maxLength' => 100,
            ])
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'test',
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
