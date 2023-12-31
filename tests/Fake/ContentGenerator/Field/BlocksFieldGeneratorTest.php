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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\BlocksFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\BlockGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use PHPUnit\Framework\TestCase;

class BlocksFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): BlocksFieldGenerator
    {
        return new BlocksFieldGenerator(BlockGeneratorTest::getGenerator(), self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $block = $generator(['list']);
        self::assertIsArray($block);
        self::assertNotEmpty($block);
        self::assertInstanceOf(Block::class, $block[0]);
    }
}
