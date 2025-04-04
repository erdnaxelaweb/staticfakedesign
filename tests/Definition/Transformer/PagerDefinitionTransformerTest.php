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
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\PagerDefinitionTransformer;
use PHPUnit\Framework\TestCase;

class PagerDefinitionTransformerTest extends TestCase
{
    private PagerDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): PagerDefinitionTransformer
    {
        return new PagerDefinitionTransformer(
            PagerFilterDefinitionTransformerTest::getTransformer(),
            PagerSortDefinitionTransformerTest::getTransformer()
        );
    }

    public function testFromHashTransformsPagerDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'pager1',
            'hash' => [
                'contentTypes' => ['type1', 'type2'],
                'maxPerPage' => 10,
                'sorts' => [
                    "sort1" => [
                        'type' => 'sort_type',
                        'options' => [
                            'option1' => 'value1',
                        ],
                    ],
                ],
                'filters' => [
                    "filter1" => [
                        'type' => 'text',
                        'options' => [
                            'option1' => 'value1',
                        ],
                    ],
                ],
                'excludedContentTypes' => ['type3'],
                'headlineCount' => 5,
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(PagerDefinition::class, $definition);
        static::assertEquals('pager1', $definition->getIdentifier());
        static::assertEquals(['type1', 'type2'], $definition->getContentTypes());
        static::assertEquals(10, $definition->getMaxPerPage());
        static::assertEquals(5, $definition->getHeadlineCount());
        static::assertTrue($definition->hasFilter('filter1'));
        static::assertInstanceOf(PagerFilterDefinition::class, $definition->getFilter('filter1'));
        static::assertTrue($definition->hasSort('sort1'));
        static::assertInstanceOf(PagerSortDefinition::class, $definition->getSort('sort1'));
    }

    public function testToHashTransformsPagerDefinitionCorrectly(): void
    {
        $sortDefinition = new PagerSortDefinition(
            "sort1",
            'sort_type',
            new DefinitionOptions([
                'option1' => 'value1',
            ])
        );

        $filterDefinition = new PagerFilterDefinition(
            'filter1',
            'text',
            new DefinitionOptions([
                'option1' => 'value1',
            ])
        );

        $definition = new PagerDefinition(
            'pager1',
            ['type1', 'type2'],
            10,
            [
                'sort1' => $sortDefinition,
            ],
            [
                'filter1' => $filterDefinition,
            ],
            ['type3'],
            5
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'pager1',
            'hash' => [
                'contentTypes' => ['type1', 'type2'],
                'maxPerPage' => 10,
                'sorts' => [
                    "sort1" => [
                        'type' => 'sort_type',
                        'options' => [
                            'option1' => 'value1',
                        ],
                    ],
                ],
                'filters' => [
                    "filter1" => [
                        'type' => 'text',
                        'options' => [
                            'option1' => 'value1',
                        ],
                    ],
                ],
                'excludedContentTypes' => ['type3'],
                'headlineCount' => 5,
            ],
        ], $hash);
    }
}
