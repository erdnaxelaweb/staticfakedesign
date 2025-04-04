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

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\RichTextAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\RichTextGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class RichTextAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private RichTextAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): RichTextAttributeGenerator
    {
        return new RichTextAttributeGenerator(RichTextGeneratorTest::getGenerator());
    }

    public function testGenerator(): void
    {
        $richtext = ($this->generator)();
        self::assertStringStartsWith('<?xml version="1.0"?>', $richtext);
    }
}
