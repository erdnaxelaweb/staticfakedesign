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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use PHPUnit\Framework\TestCase;

class ContentGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private ContentGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): ContentGenerator
    {
        return new ContentGenerator(
            DefinitionManagerTest::getManager(),
            BreadcrumbGeneratorTest::getGenerator(),
            ContentFieldGeneratorRegistryTest::getRegistry(),
            self::getFakerGenerator(),
        );
    }

    public function testGenerator(): void
    {
        $content = ($this->generator)('article');
        self::assertInstanceOf(Content::class, $content);

        $content = ($this->generator)(['article', 'article']);
        self::assertInstanceOf(Content::class, $content);
    }
}
