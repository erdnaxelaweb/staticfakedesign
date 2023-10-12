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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BlockGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\BlockConfigurationManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use PHPUnit\Framework\TestCase;

class BlockGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): BlockGenerator
    {
        return new BlockGenerator(
            BlockConfigurationManagerTest::getManager(),
            self::getFakerGenerator(),
            ContentFieldGeneratorRegistryTest::getRegistry()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();
        $block = $generator('list');
        self::assertInstanceOf(Block::class, $block);
        self::assertNotNull($block->name);
        self::assertNotEmpty($block->fields);
        self::assertNotEmpty('default', $block->view);

        $block = $generator('list', 'headline');
        self::assertInstanceOf(Block::class, $block);
        self::assertNotNull($block->name);
        self::assertNotEmpty($block->fields);
        self::assertNotEmpty('headline', $block->view);
    }
}
