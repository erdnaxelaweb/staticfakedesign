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
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\RecordDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DefinitionTransformerInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DefinitionTransformerTest extends TestCase
{
    private DefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): DefinitionTransformer
    {
        $transformer = new DefinitionTransformer();
        $transformer->registerTransformer(
            BlockAttributeDefinition::DEFINITION_TYPE,
            BlockAttributeDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(BlockDefinition::DEFINITION_TYPE, BlockDefinitionTransformerTest::getTransformer());
        $transformer->registerTransformer(
            BlockLayoutDefinition::DEFINITION_TYPE,
            BlockLayoutDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            BlockLayoutSectionDefinition::DEFINITION_TYPE,
            BlockLayoutSectionDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            ContentDefinition::DEFINITION_TYPE,
            ContentDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            ContentFieldDefinition::DEFINITION_TYPE,
            ContentFieldDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(PagerDefinition::DEFINITION_TYPE, PagerDefinitionTransformerTest::getTransformer());
        $transformer->registerTransformer(
            PagerFilterDefinition::DEFINITION_TYPE,
            PagerFilterDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            PagerSortDefinition::DEFINITION_TYPE,
            PagerSortDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            TaxonomyEntryDefinition::DEFINITION_TYPE,
            TaxonomyEntryDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            RecordDefinition::DEFINITION_TYPE,
            RecordDefinitionTransformerTest::getTransformer()
        );

        return $transformer;
    }

    public function testRegisterTransformerStoresTransformerCorrectly(): void
    {
        $transformer = $this->createMock(DefinitionTransformerInterface::class);
        $this->transformer->registerTransformer('type1', $transformer);

        static::assertSame($transformer, $this->transformer->getTransformer('type1'));
    }

    public function testGetTransformerThrowsExceptionForUnknownType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No transformer found for type unknown_type');

        $this->transformer->getTransformer('unknown_type');
    }

    public function testFromHashTransformsHashToDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'identifier1',
            'hash' => [
                'key' => 'value',
            ],
        ];
        $definition = $this->createMock(DefinitionInterface::class);
        $transformer = $this->createMock(DefinitionTransformerInterface::class);
        $transformer->method('fromHash')
            ->willReturn($definition);

        $this->transformer->registerTransformer('type1', $transformer);

        $result = $this->transformer->fromHash('type1', $hash);

        static::assertSame($definition, $result);
    }

    public function testToHashTransformsDefinitionToHashCorrectly(): void
    {
        $definition = $this->createMock(DefinitionInterface::class);
        $hash = [
            'identifier' => 'identifier1',
            'hash' => [
                'key' => 'value',
            ],
        ];
        $transformer = $this->createMock(DefinitionTransformerInterface::class);
        $transformer->method('toHash')
            ->willReturn($hash);

        $this->transformer->registerTransformer('type1', $transformer);

        $result = $this->transformer->toHash('type1', $definition);

        static::assertSame($hash, $result);
    }
}
