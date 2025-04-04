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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\SvgFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class SvgFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private SvgFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): SvgFieldGenerator
    {
        return new SvgFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $svg = ($this->generator)();
        self::assertStringContainsString('<svg width="200" height="200"', $svg);
        self::assertStringContainsString('</svg>', $svg);
        
        // Test with custom parameters
        $width = 300;
        $height = 400;
        $numShapes = 5;
        
        $svg = ($this->generator)($width, $height, $numShapes);
        self::assertStringContainsString("<svg width=\"{$width}\" height=\"{$height}\"", $svg);
        
        // Count shapes (circles and rectangles)
        $circleCount = substr_count($svg, '<circle ');
        $rectCount = substr_count($svg, '<rect ');
        
        self::assertEquals($numShapes, $circleCount + $rectCount);
    }
}
