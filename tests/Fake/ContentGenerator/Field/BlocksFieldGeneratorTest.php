<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\BlocksFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\BlockGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Layout;
use ErdnaxelaWeb\StaticFakeDesign\Value\LayoutZone;
use PHPUnit\Framework\TestCase;

class BlocksFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private BlocksFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): BlocksFieldGenerator
    {
        return new BlocksFieldGenerator(
            BlockGeneratorTest::getGenerator(),
            DefinitionManagerTest::getManager(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator(): void
    {
        $block = ($this->generator)('default', ['list']);

        self::assertArrayHasKey('layout', $block);
        self::assertInstanceOf(Layout::class, $block['layout']);

        self::assertArrayHasKey('zones', $block);
        self::assertNotEmpty($block['zones']);
        self::assertArrayHasKey('default', $block['zones']);
        self::assertInstanceOf(LayoutZone::class, $block['zones']['default']);
    }
}
