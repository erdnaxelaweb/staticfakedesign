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

use ErdnaxelaWeb\StaticFakeDesign\Definition\RecordDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\RecordDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class RecordDefinitionTransformerTest extends TestCase
{
    private RecordDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): RecordDefinitionTransformer
    {
        return new RecordDefinitionTransformer();
    }

    public function testFromHash(): void
    {
        $hash = [
            'identifier' => 'test_record',
            'hash' => [
                'sources' => [
                    'source1' => 'value1',
                    'source2' => 'value2',
                ],
                'attributes' => [
                    'id' => 'integer',
                    'name' => 'string',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        $this->assertInstanceOf(RecordDefinition::class, $definition);
        $this->assertEquals('test_record', $definition->getIdentifier());
        $this->assertEquals([
            'source1' => 'value1',
            'source2' => 'value2',
        ], $definition->getSources());
        $this->assertEquals([
            'id' => 'integer',
            'name' => 'string',
        ], $definition->getAttributes());
    }

    public function testToHash(): void
    {
        $definition = new RecordDefinition(
            'test_record',
            [
                'source1' => 'value1',
                'source2' => 'value2',
            ],
            [
                'id' => 'integer',
                'name' => 'string',
            ]
        );

        $hash = $this->transformer->toHash($definition);

        $expectedHash = [
            'identifier' => 'test_record',
            'hash' => [
                'sources' => [
                    'source1' => 'value1',
                    'source2' => 'value2',
                ],
                'attributes' => [
                    'id' => 'integer',
                    'name' => 'string',
                ],
            ],
        ];

        $this->assertEquals($expectedHash, $hash);
    }
}
