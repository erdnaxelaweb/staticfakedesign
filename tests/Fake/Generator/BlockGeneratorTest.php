<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BlockGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\AttributeGeneratorRegistryTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use PHPUnit\Framework\TestCase;

class BlockGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private BlockGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): BlockGenerator
    {
        return new BlockGenerator(
            DefinitionManagerTest::getManager(),
            AttributeGeneratorRegistryTest::getRegistry(),
            self::getFakerGenerator(),
        );
    }

    public function testGenerator(): void
    {
        $block = ($this->generator)('list');
        self::assertInstanceOf(Block::class, $block);
        self::assertNotEmpty($block->name);
        self::assertNotTrue($block->attributes->isEmpty());
        self::assertEquals('default', $block->view);

        $block = ($this->generator)('list', 'headline');
        self::assertInstanceOf(Block::class, $block);
        self::assertNotEmpty($block->name);
        self::assertNotTrue($block->attributes);
        self::assertEquals('headline', $block->view);
    }
}
