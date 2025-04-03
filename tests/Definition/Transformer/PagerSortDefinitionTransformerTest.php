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

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\PagerSortDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class PagerSortDefinitionTransformerTest extends TestCase
{
    private PagerSortDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): PagerSortDefinitionTransformer
    {
        return new PagerSortDefinitionTransformer();
    }

    public function testFromHashTransformsPagerSortDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'sort1',
            'hash' => [
                'type' => 'sort_type',
                'options' => [
                    'option1' => 'value1',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(PagerSortDefinition::class, $definition);
        static::assertEquals('sort1', $definition->getIdentifier());
        static::assertEquals('sort_type', $definition->getType());
        self::assertEquals('value1', $definition->getOptions()->get('option1'));
    }

    public function testToHashTransformsPagerSortDefinitionCorrectly(): void
    {
        $definition = new PagerSortDefinition(
            "sort1",
            'sort_type',
            new DefinitionOptions([
                'option1' => 'value1',
            ])
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'sort1',
            'hash' => [
                'type' => 'sort_type',
                'options' => [
                    'option1' => 'value1',
                ],
            ],
        ], $hash);
    }
}
