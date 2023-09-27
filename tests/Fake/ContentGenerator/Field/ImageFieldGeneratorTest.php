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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\ImageFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ImageGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class ImageFieldGeneratorTest extends TestCase
{

    use GeneratorTestTrait;
    public static function getGenerator(  ): ImageFieldGenerator
    {
        return new ImageFieldGenerator(ImageGeneratorTest::getGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $imageGenerator = $generator();
        self::assertInstanceOf(ImageGenerator::class, $imageGenerator);
    }
}
