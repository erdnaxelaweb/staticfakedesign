<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\PagerConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Exception\ConfigurationNotFoundException;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\SearchFormGeneratorTest;
use PHPUnit\Framework\TestCase;

class PagerConfigurationManagerTest extends TestCase
{
    public static function getManager(): PagerConfigurationManager
    {
        return new PagerConfigurationManager(
            [
                'articles_list' => [
                    'contentTypes' => ['article'],
                    'filters' => [
                        'title' => [
                            'field' => 'title',
                            'type' => 'fulltext',
                        ],
                        'selection' => [
                            'field' => 'selection',
                            'type' => 'checkbox',
                        ],
                    ],
                    'sorts' => ['title', 'date'],
                    'maxPerPage' => 5,
                ],
            ],
            SearchFormGeneratorTest::getGenerator()
        );
    }

    public function testGetConfiguration()
    {
        $configuration = self::getManager();
        $configuration = $configuration->getConfiguration('articles_list');
        self::assertIsArray($configuration);
        self::assertArrayHasKey('contentTypes', $configuration);
        self::assertCount(1, $configuration['contentTypes']);
        self::assertArrayHasKey('filters', $configuration);
        self::assertArrayHasKey('sorts', $configuration);
        self::assertCount(2, $configuration['sorts']);
        self::assertArrayHasKey('maxPerPage', $configuration);
        self::assertArrayHasKey('maxPerPage', $configuration);
        self::assertEquals(5, $configuration['maxPerPage']);
    }

    public function testGetConfigurationNotFound()
    {
        $configuration = self::getManager();

        $this->expectException(ConfigurationNotFoundException::class);
        $configuration = $configuration->getConfiguration('notfound');
    }
}
