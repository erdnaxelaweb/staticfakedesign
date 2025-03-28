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
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DefinitionTransformerInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DefinitionTransformerTest extends TestCase
{
    private DefinitionTransformer $transformer;

    public static function getTransformer(): DefinitionTransformer
    {
        $transformer = new DefinitionTransformer();
        $transformer->registerTransformer(
            BlockAttributeDefinition::class,
            BlockAttributeDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(BlockDefinition::class, BlockDefinitionTransformerTest::getTransformer());
        $transformer->registerTransformer(
            BlockLayoutDefinition::class,
            BlockLayoutDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            BlockLayoutSectionDefinition::class,
            BlockLayoutSectionDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            ContentDefinition::class,
            ContentDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            ContentFieldDefinition::class,
            ContentFieldDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(PagerDefinition::class, PagerDefinitionTransformerTest::getTransformer());
        $transformer->registerTransformer(
            PagerFilterDefinition::class,
            PagerFilterDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            PagerSortDefinition::class,
            PagerSortDefinitionTransformerTest::getTransformer()
        );
        $transformer->registerTransformer(
            TaxonomyEntryDefinition::class,
            TaxonomyEntryDefinitionTransformerTest::getTransformer()
        );

        return $transformer;
    }

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
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
