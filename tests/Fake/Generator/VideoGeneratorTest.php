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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\VideoGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use ErdnaxelaWeb\StaticFakeDesign\Value\Video;
use PHPUnit\Framework\TestCase;

class VideoGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private VideoGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): VideoGenerator
    {
        return new VideoGenerator(
            ImageGeneratorTest::getGenerator(),
            RichTextGeneratorTest::getGenerator(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator(): void
    {
        $video = ($this->generator)();
        self::assertInstanceOf(Video::class, $video);
        self::assertNull($video->image);
        self::assertTrue($video->hasSource());

        $video = ($this->generator)('large');
        self::assertInstanceOf(Video::class, $video);
        self::assertInstanceOf(Image::class, $video->image);
        self::assertTrue($video->hasSource());
    }
}
