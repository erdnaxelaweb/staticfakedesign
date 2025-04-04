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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\ImageFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ImageGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class ImageFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private ImageFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): ImageFieldGenerator
    {
        return new ImageFieldGenerator(ImageGeneratorTest::getGenerator());
    }

    public function testGenerator(): void
    {
        $imageGenerator = ($this->generator)();
        self::assertInstanceOf(ImageGenerator::class, $imageGenerator);
    }
}
