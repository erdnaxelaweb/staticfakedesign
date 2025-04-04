<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ImageVariationSourceDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Exception\VariationConfigurationNotFoundException;
use PHPUnit\Framework\TestCase;

class ImageConfigurationTest extends TestCase
{
    private ImageConfiguration $imageConfiguration;

    protected function setUp(): void
    {
        $this->imageConfiguration = self::getConfiguration();
    }

    public static function getConfiguration(): ImageConfiguration
    {
        return new ImageConfiguration(
            [
                "breakpoints" => [
                    [
                        'suffix' => 'desktop',
                        'media' => '(min-width: 1024px)',
                        'use_webp' => false,
                    ],
                    [
                        'suffix' => 'tablet',
                        'media' => '(min-width: 754px)',
                        'use_webp' => true,
                    ],
                    [
                        'suffix' => 'mobile',
                        'media' => '(min-width: 0)',
                        'use_webp' => ImageConfiguration::FORCE_WEBP,
                    ],
                ],
                "variations" => [
                    'large' => [[200, 200], [100, 100], [50, 50]],
                ],
            ]
        );
    }

    public function testGetVariationConfiguration(): void
    {
        $configurations = $this->imageConfiguration->getVariationConfig('large');
        self::assertCount(4, $configurations);
        self::assertInstanceOf(ImageVariationSourceDefinition::class, $configurations[0]);
        self::assertEquals('desktop', $configurations[0]->getSuffix());
        self::assertEquals('(min-width: 1024px)', $configurations[0]->getMedia());
        self::assertEquals(200, $configurations[0]->getHeight());
        self::assertEquals(200, $configurations[0]->getWidth());
    }

    public function testGetVariationConfigurationNotFound(): void
    {
        $this->expectException(VariationConfigurationNotFoundException::class);
        $configuration = $this->imageConfiguration->getVariationConfig('notfound');
    }
}
