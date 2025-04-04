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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\AudioGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Audio;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use PHPUnit\Framework\TestCase;

class AudioGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private AudioGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): AudioGenerator
    {
        return new AudioGenerator(ImageGeneratorTest::getGenerator(), self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $audio = ($this->generator)();
        self::assertInstanceOf(Audio::class, $audio);
        self::assertNull($audio->image);
        self::assertTrue($audio->hasSource());

        $audio = ($this->generator)('large');
        self::assertInstanceOf(Audio::class, $audio);
        self::assertInstanceOf(Image::class, $audio->image);
        self::assertTrue($audio->hasSource());
    }
}
