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

declare( strict_types=1 );

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

    public static function getGenerator(  ): ContentGenerator
    {
            return new ContentGenerator(
                ContentConfigurationManagerTest::getConfiguration(),
                BreadcrumbGeneratorTest::getGenerator(),
                self::getFakerGenerator(),
                ContentFieldGeneratorRegistryTest::getRegistry()
            );
    }

    public function testGenerator(  )
    {
        $generator = self::getGenerator();
        $taxonomyEntry = $generator('article');
        self::assertInstanceOf(Content::class, $taxonomyEntry);
    }

}
