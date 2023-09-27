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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\VideoGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use ErdnaxelaWeb\StaticFakeDesign\Value\Video;
use PHPUnit\Framework\TestCase;

class VideoGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): VideoGenerator
    {
        return new VideoGenerator(
            ImageGeneratorTest::getGenerator(),
            RichTextGeneratorTest::getGenerator(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();
        $video = $generator();
        self::assertInstanceOf(Video::class, $video);
        self::assertNull($video->image);
        self::assertTrue($video->hasSource());

        $video = $generator('large');
        self::assertInstanceOf(Video::class, $video);
        self::assertInstanceOf(Image::class, $video->image);
        self::assertTrue($video->hasSource());
    }
}
