<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\ContentConfigurationManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use PHPUnit\Framework\TestCase;

class ContentGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): ContentGenerator
    {
        return new ContentGenerator(
            ContentConfigurationManagerTest::getManager(),
            BreadcrumbGeneratorTest::getGenerator(),
            self::getFakerGenerator(),
            ContentFieldGeneratorRegistryTest::getRegistry()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();
        $content = $generator('article');
        self::assertInstanceOf(Content::class, $content);

        $content = $generator(['article', 'article']);
        self::assertInstanceOf(Content::class, $content);
    }
}
