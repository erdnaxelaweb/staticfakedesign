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

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\ContentAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use PHPUnit\Framework\TestCase;

class ContentAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private ContentAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): ContentAttributeGenerator
    {
        return new ContentAttributeGenerator(ContentGeneratorTest::getGenerator());
    }

    public function testGenerator(): void
    {
        $content = ($this->generator)('article');
        self::assertInstanceOf(Content::class, $content);

        $content = ($this->generator)(['article', 'article']);
        self::assertInstanceOf(Content::class, $content);

        $contents = ($this->generator)('article', 5);
        self::assertIsArray($contents);
        self::assertNotEmpty($contents);
        self::assertInstanceOf(Content::class, $contents[0]);
    }
}
