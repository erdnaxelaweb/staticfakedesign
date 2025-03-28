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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\RecordConfigurationManager;
use PHPUnit\Framework\TestCase;

class RecordConfigurationManagerTest extends TestCase
{
    public static function getManager(): RecordConfigurationManager
    {
        return new RecordConfigurationManager(
            [
                'article' => [
                    'sources' => [
                        'content' => 'content("article")',
                    ],
                    "attributes" => [
                        'id' => 'content.id',
                        'title' => 'content.fields.title',
                    ],
                ],
            ]
        );
    }

    public function testGetConfiguration()
    {
        $manager = self::getManager();
        $configuration = $manager->getConfiguration('article');
        self::assertIsArray($configuration);
        self::assertArrayHasKey('sources', $configuration);
        self::assertArrayHasKey('content', $configuration['sources']);
        self::assertEquals('content("article")', $configuration['sources']['content']);
        self::assertArrayHasKey('attributes', $configuration);
        self::assertArrayHasKey('id', $configuration['attributes']);
        self::assertArrayHasKey('title', $configuration['attributes']);
        self::assertEquals('content.fields.title', $configuration['attributes']['title']);
    }
}
