<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\TextAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class TextAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private TextAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): TextAttributeGenerator
    {
        return new TextAttributeGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $text = ($this->generator)();
        self::assertGreaterThan(0, strlen($text));
    }
}
