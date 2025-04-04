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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\ImageConfigurationTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use ErdnaxelaWeb\StaticFakeDesign\Value\ImageSource;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class ImageGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private ImageGenerator $generator;

    private ImageGenerator $generatorWithProvider;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
        $this->generatorWithProvider = self::getGenerator(
            [
                'randomize' => false,
                'gray' => false,
            ],
            "\\Smknstd\\FakerPicsumImages\\FakerPicsumImagesProvider",
        );
    }

    /**
     * @param array<string, mixed>       $imageProviderParameters
     */
    public static function getGenerator(
        array $imageProviderParameters = [],
        ?string $imageProviderClass = null,
        string $locale = Factory::DEFAULT_LOCALE
    ): ImageGenerator {
        $imageConfiguration = ImageConfigurationTest::getConfiguration();

        return new ImageGenerator($imageConfiguration, self::getFakerGenerator(
            $imageProviderParameters,
            $imageProviderClass,
            $locale
        ));
    }

    public function testInvoke(): void
    {
        $image = ($this->generator)('large');
        self::assertInstanceOf(Image::class, $image);
        self::assertTrue($image->hasSource());
        self::assertCount(4, $image->sources);

        $defaultSource = $image->getDefaultSource();
        self::assertInstanceOf(ImageSource::class, $defaultSource);
        self::assertEquals(200, $defaultSource->height);
        self::assertEquals(200, $defaultSource->width);
        self::assertEquals('(min-width: 1024px)', $defaultSource->media);
        self::assertEquals('desktop', $defaultSource->variation);
        self::assertStringStartsWith('https://via.placeholder.com/', $defaultSource->getUri());

        $image = ($this->generatorWithProvider)('large');
        self::assertInstanceOf(Image::class, $image);
        self::assertTrue($image->hasSource());
        self::assertCount(4, $image->sources);

        $defaultSource = $image->getDefaultSource();
        self::assertEquals(200, $defaultSource->height);
        self::assertEquals(200, $defaultSource->width);
        self::assertEquals('(min-width: 1024px)', $defaultSource->media);
        self::assertEquals('desktop', $defaultSource->variation);
        self::assertStringStartsWith('https://picsum.photos/', $defaultSource->getUri());

        $image = ($this->generatorWithProvider)('large', 1);
        self::assertInstanceOf(Image::class, $image);
        self::assertTrue($image->hasSource());
        self::assertCount(4, $image->sources);

        $defaultSource = $image->getDefaultSource();
        self::assertEquals(200, $defaultSource->height);
        self::assertEquals(200, $defaultSource->width);
        self::assertEquals('(min-width: 1024px)', $defaultSource->media);
        self::assertEquals('desktop', $defaultSource->variation);
        self::assertStringStartsWith('https://picsum.photos/id/1/', $defaultSource->getUri());
    }
}
