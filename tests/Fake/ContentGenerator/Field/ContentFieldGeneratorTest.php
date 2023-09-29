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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\ContentFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use PHPUnit\Framework\TestCase;

class ContentFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): ContentFieldGenerator
    {
        return new ContentFieldGenerator(ContentGeneratorTest::getGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $content = $generator('article');
        self::assertInstanceOf(Content::class, $content);

        $contents = $generator('article', 5);
        self::assertIsArray($contents);
        self::assertNotEmpty($contents);
        self::assertInstanceOf(Content::class, $contents[0]);
    }
}
