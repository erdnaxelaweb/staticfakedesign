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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Exception\ConfigurationNotFoundException;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use PHPUnit\Framework\TestCase;

class BlockConfigurationManagerTest extends TestCase
{
    public static function getManager(): BlockConfigurationManager
    {
        return new BlockConfigurationManager(
            [
                'list' => [
                    'fields' => [
                        'title' => [
                            'required' => true,
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            ContentFieldGeneratorRegistryTest::getRegistry()
        );
    }

    public function testGetConfiguration()
    {
        $configuration = self::getManager();
        $configuration = $configuration->getConfiguration('list');
        self::assertIsArray($configuration);
        self::assertArrayHasKey('fields', $configuration);
        self::assertArrayHasKey('title', $configuration['fields']);
        self::assertArrayHasKey('required', $configuration['fields']['title']);
        self::assertArrayHasKey('type', $configuration['fields']['title']);
        self::assertArrayHasKey('options', $configuration['fields']['title']);
        self::assertEquals('string', $configuration['fields']['title']['type']);
        self::assertTrue($configuration['fields']['title']['required']);
        self::assertIsArray($configuration['fields']['title']['options']);
    }

    public function testGetConfigurationNotFound()
    {
        $configuration = self::getManager();

        $this->expectException(ConfigurationNotFoundException::class);
        $configuration = $configuration->getConfiguration('notfound');
    }
}
