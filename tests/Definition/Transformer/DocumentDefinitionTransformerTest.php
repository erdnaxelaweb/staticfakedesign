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

use ErdnaxelaWeb\StaticFakeDesign\Definition\DocumentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DocumentDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class DocumentDefinitionTransformerTest extends TestCase
{
    private DocumentDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): DocumentDefinitionTransformer
    {
        return new DocumentDefinitionTransformer();
    }

    public function testFromHash(): void
    {
        $hash = [
            'identifier' => 'test_document',
            'hash' => [
                'source' => 'type',
                'fields' => [
                    'id' => 'integer',
                    'name' => 'string',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        $this->assertEquals('test_document', $definition->getIdentifier());
        $this->assertEquals('type', $definition->getSource());
        $this->assertEquals([
            'id' => 'integer',
            'name' => 'string',
        ], $definition->getFields());
    }

    public function testToHash(): void
    {
        $definition = new DocumentDefinition(
            'test_document',
            'type',
            [
                'id' => 'integer',
                'name' => 'string',
            ]
        );

        $hash = $this->transformer->toHash($definition);

        $expectedHash = [
            'identifier' => 'test_document',
            'hash' => [
                'source' => 'type',
                'fields' => [
                    'id' => 'integer',
                    'name' => 'string',
                ],
            ],
        ];

        $this->assertEquals($expectedHash, $hash);
    }
}
