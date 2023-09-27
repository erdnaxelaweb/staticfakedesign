<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare( strict_types=1 );

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

    public static function getGenerator(  ): BlockGenerator
    {
            return new BlockGenerator(
                BlockConfigurationManagerTest::getConfiguration(),
                self::getFakerGenerator(),
                ContentFieldGeneratorRegistryTest::getRegistry()
            );
    }

    public function testGenerator(  )
    {
        $generator = self::getGenerator();
        $block = $generator('list');
        self::assertInstanceOf(Block::class, $block);
        self::assertNotNull($block->name);
        self::assertNotEmpty($block->fields);
    }

}
