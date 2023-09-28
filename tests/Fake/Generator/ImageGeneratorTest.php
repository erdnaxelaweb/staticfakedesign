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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\ImageConfigurationTest;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class ImageGeneratorTest extends TestCase
{
use GeneratorTestTrait;
    public static function getGenerator(array $imageProviderParameters = [], ?string $imageProviderClass = null, $locale = Factory::DEFAULT_LOCALE): ImageGenerator
    {
        $imageConfiguration = ImageConfigurationTest::getConfiguration();

        return new ImageGenerator($imageConfiguration, self::getFakerGenerator($imageProviderParameters, $imageProviderClass, $locale));
    }

    public function testInvoke(  )
    {
        $generator = self::getGenerator();

        $image = $generator('large');
        self::assertInstanceOf(Image::class, $image);
        self::assertTrue( $image->hasSource());
        self::assertCount(3,  $image->sources);

        $defaultSource = $image->getDefaultSource();
        self::assertEquals(200, $defaultSource->height);
        self::assertEquals(200, $defaultSource->width);
        self::assertEquals('(min-width: 1024px)', $defaultSource->media);
        self::assertEquals('desktop', $defaultSource->variation);
        self::assertStringStartsWith('https://via.placeholder.com/', $defaultSource->uri);

        $generator = self::getGenerator(
            ['randomize' =>  false, 'gray' => false],
            "\\Smknstd\\FakerPicsumImages\\FakerPicsumImagesProvider",
        );

        $image = $generator('large');
        self::assertInstanceOf(Image::class, $image);
        self::assertTrue( $image->hasSource());
        self::assertCount(3,  $image->sources);

        $defaultSource = $image->getDefaultSource();
        self::assertEquals(200, $defaultSource->height);
        self::assertEquals(200, $defaultSource->width);
        self::assertEquals('(min-width: 1024px)', $defaultSource->media);
        self::assertEquals('desktop', $defaultSource->variation);
        self::assertStringStartsWith('https://picsum.photos/',  $defaultSource->uri);

        $image = $generator('large', 1);
        self::assertInstanceOf(Image::class, $image);
        self::assertTrue( $image->hasSource());
        self::assertCount(3,  $image->sources);

        $defaultSource = $image->getDefaultSource();
        self::assertEquals(200, $defaultSource->height);
        self::assertEquals(200, $defaultSource->width);
        self::assertEquals('(min-width: 1024px)', $defaultSource->media);
        self::assertEquals('desktop', $defaultSource->variation);
        self::assertStringStartsWith('https://picsum.photos/id/1/',  $defaultSource->uri);
    }
}
