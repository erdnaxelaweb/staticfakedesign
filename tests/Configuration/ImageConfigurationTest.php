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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;
use ErdnaxelaWeb\StaticFakeDesign\Exception\VariationConfigurationNotFoundException;
use PHPUnit\Framework\TestCase;

class ImageConfigurationTest extends TestCase
{
    public static function getConfiguration(): ImageConfiguration
    {
        return new ImageConfiguration(
            [
                [
                    'suffix' => 'desktop',
                    'media' => '(min-width: 1024px)',
                ],
                [
                    'suffix' => 'tablet',
                    'media' => '(min-width: 754px)',
                ],
                [
                    'suffix' => 'mobile',
                    'media' => '(min-width: 0)',
                ],
            ],
            [
                'large' => [[200, 200], [100, 100], [50, 50]],
            ]
        );
    }

    public function testGetVariationConfiguration()
    {
        $imageConfiguration = self::getConfiguration();
        $configuration = $imageConfiguration->getVariationConfig('large');
        self::assertIsArray($configuration);
        self::assertCount(3, $configuration);
        self::assertArrayHasKey('suffix', $configuration[0]);
        self::assertArrayHasKey('media', $configuration[0]);
        self::assertArrayHasKey('height', $configuration[0]);
        self::assertArrayHasKey('width', $configuration[0]);
    }

    public function testGetVariationConfigurationNotFound()
    {
        $imageConfiguration = self::getConfiguration();

        $this->expectException(VariationConfigurationNotFoundException::class);
        $configuration = $imageConfiguration->getVariationConfig('notfound');
    }
}
