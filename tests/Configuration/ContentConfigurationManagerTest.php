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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ContentConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Exception\ConfigurationNotFoundException;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use PHPUnit\Framework\TestCase;

class ContentConfigurationManagerTest extends TestCase
{
    public static function getManager(): ContentConfigurationManager
    {
        return new ContentConfigurationManager(
            [
                'list' => [
                    'fields' => [
                        'title' => [
                            'required' => true,
                            'type' => 'string',
                        ],
                    ],
                ],
                'product' => [
                    'fields' => [
                        'title' => [
                            'required' => true,
                            'type' => 'string',
                        ],
                    ],
                ],
                'article' => [
                    'parent' => ['list'],
                    'fields' => [
                        'title' => [
                            'required' => true,
                            'type' => 'string',
                        ],
                        'summay' => [
                            'required' => true,
                            'type' => 'text',
                        ],
                        'description' => [
                            'required' => true,
                            'type' => 'richtext',
                        ],
                        'image' => [
                            'required' => true,
                            'type' => 'image',
                        ],
                        'tag' => [
                            'required' => true,
                            'type' => 'taxonomy_entry',
                            'options' => [
                                'type' => 'tag',
                            ],
                        ],
                        'tags' => [
                            'required' => true,
                            'type' => 'taxonomy_entry',
                            'options' => [
                                'type' => 'tag',
                                'max' => 2,
                            ],
                        ],
                        'product' => [
                            'required' => true,
                            'type' => 'content',
                            'options' => [
                                'type' => 'product',
                                'max' => 1,
                            ],
                        ],
                        'products' => [
                            'required' => true,
                            'type' => 'content',
                            'options' => [
                                'type' => ['product', 'product'],
                                'max' => 2,
                            ],
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
        $configuration = $configuration->getConfiguration('article');
        self::assertIsArray($configuration);
        self::assertArrayHasKey('fields', $configuration);
        self::assertArrayHasKey('title', $configuration['fields']);
        self::assertArrayHasKey('required', $configuration['fields']['title']);
        self::assertArrayHasKey('type', $configuration['fields']['title']);
        self::assertArrayHasKey('options', $configuration['fields']['title']);
        self::assertArrayHasKey('parent', $configuration);
        self::assertEquals('string', $configuration['fields']['title']['type']);
        self::assertTrue($configuration['fields']['title']['required']);
        self::assertIsArray($configuration['fields']['title']['options']);
        self::assertIsArray($configuration['parent']);
    }

    public function testGetConfigurationNotFound()
    {
        $configuration = self::getManager();

        $this->expectException(ConfigurationNotFoundException::class);
        $configuration = $configuration->getConfiguration('notfound');
    }
}
