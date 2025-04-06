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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerSortDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\RecordDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Definition\Transformer\DefinitionTransformerTest;
use PHPUnit\Framework\TestCase;

class DefinitionManagerTest extends TestCase
{
    private DefinitionManager $manager;

    private static ?DefinitionManager $staticManager = null;

    protected function setUp(): void
    {
        $this->manager = static::getManager();
    }

    public static function getManager(): DefinitionManager
    {
        if (self::$staticManager) {
            return self::$staticManager;
        }

        $manager = new DefinitionManager(DefinitionTransformerTest::getTransformer());
        $manager->registerDefinitions(
            BlockDefinition::DEFINITION_TYPE,
            [
                'list' => [
                    'attributes' => [
                        'title' => [
                            'required' => true,
                            'type' => 'string',
                        ],
                    ],
                    'views' => [
                        'default' => 'block/elements/default.html.twig',
                    ],
                ],
            ]
        );

        $manager->registerDefinitions(
            BlockLayoutDefinition::DEFINITION_TYPE,
            [
                'default' => [
                    'template' => "layout/default.html.twig",
                    'zones' => ['default'],
                    'sections' => [
                        'default' => [
                            'blocks' => [],
                            'template' => 'layout/section/default.html.twig',
                        ],
                    ],
                ],
            ]
        );

        $manager->registerDefinitions(
            ContentDefinition::DEFINITION_TYPE,
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
                    'models' => [
                        [
                            'title' => 'test article',
                        ],
                    ],
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
                            'options' => [
                                'allowedTags' => ['p'],
                                'maxWidth' => 1,
                            ],
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
                                'max' => 10,
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
            ]
        );

        $manager->registerDefinitions(
            PagerDefinition::DEFINITION_TYPE,
            [
                'articles_list' => [
                    'contentTypes' => ['article'],
                    'filters' => [
                        'title' => [
                            'type' => 'text',
                        ],
                        'selection' => [
                            'type' => 'checkbox',
                        ],
                    ],
                    'sorts' => [
                        'aggregate' => [
                            'type' => 'aggregate',
                            'options' => [
                                'sorts' => [
                                    'name' => [
                                        'type' => 'content.name',
                                        'options' => [
                                            'direction' => 'ascending',
                                        ],
                                    ],
                                    'date_published' => [
                                        'type' => 'content.date_published',
                                        'options' => [
                                            'direction' => 'descending',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'name' => [
                            'type' => 'content.name',
                            'options' => [
                                'direction' => 'ascending',
                            ],
                        ],
                        'date_published' => [
                            'type' => 'content.date_published',
                            'options' => [
                                'direction' => 'descending',
                            ],
                        ],
                    ],
                    'maxPerPage' => 5,
                    'headlineCount' => 2,
                ],
            ]
        );

        $manager->registerDefinitions(
            TaxonomyEntryDefinition::DEFINITION_TYPE,
            [
                'tag' => [
                    'models' => [
                        [
                            'title' => 'test tag',
                        ],
                    ],
                    'fields' => [
                        'title' => [
                            'required' => true,
                            'type' => 'string',
                        ],
                    ],
                ],
            ]
        );

        $manager->registerDefinitions(
            RecordDefinition::DEFINITION_TYPE,
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

        self::$staticManager = $manager;

        return $manager;
    }

    public function testBlockDefinition(): void
    {
        $configuration = $this->manager->getDefinition(BlockDefinition::class, 'list');
        self::assertInstanceOf(BlockDefinition::class, $configuration);
        self::assertArrayHasKey('title', $configuration->getAttributes());

        $titleAttribute = $configuration->getAttribute('title');
        self::assertEquals('string', $titleAttribute->getType());
        self::assertTrue($titleAttribute->isRequired());
        self::assertEquals(100, $titleAttribute->getOptions()->get('maxLength'));

        self::assertArrayHasKey('default', $configuration->getViews());
        self::assertEquals('block/elements/default.html.twig', $configuration->getView('default'));
    }

    public function testBlockLayoutDefinition(): void
    {
        $configuration = $this->manager->getDefinition(BlockLayoutDefinition::class, 'default');
        self::assertInstanceOf(BlockLayoutDefinition::class, $configuration);
        self::assertEquals("layout/default.html.twig", $configuration->getTemplate());
        self::assertEquals(['default'], $configuration->getZones());

        self::assertTrue($configuration->hasSection('default'));
        self::assertInstanceOf(BlockLayoutSectionDefinition::class, $configuration->getSection('default'));
        self::assertEquals(
            "layout/section/default.html.twig",
            $configuration->getSection('default')
                ->getTemplate()
        );
    }

    public function testContentDefinition(): void
    {
        $configuration = $this->manager->getDefinition(ContentDefinition::class, 'article');
        self::assertInstanceOf(ContentDefinition::class, $configuration);

        $fields = $configuration->getFields();
        self::assertTrue($configuration->hasField('title'));

        $titleField = $configuration->getField('title');
        self::assertInstanceOf(ContentFieldDefinition::class, $titleField);
        self::assertEquals('string', $titleField->getType());
        self::assertTrue($titleField->isRequired());
        self::assertEquals(100, $titleField->getOptions()->get('maxLength'));
    }

    public function testPagerDefinition(): void
    {
        $configuration = $this->manager->getDefinition(PagerDefinition::class, 'articles_list');
        self::assertInstanceOf(PagerDefinition::class, $configuration);
        self::assertEquals(5, $configuration->getMaxPerPage());
        self::assertEquals(['article'], $configuration->getContentTypes());
        self::assertTrue($configuration->hasSort('name'));
        self::assertTrue($configuration->hasFilter('title'));
        self::assertInstanceOf(PagerSortDefinition::class, $configuration->getSort('name'));
        self::assertInstanceOf(PagerFilterDefinition::class, $configuration->getFilter('title'));
        self::assertEquals('text', $configuration->getFilter('title')->getType());
        self::assertEquals('checkbox', $configuration->getFilter('selection')->getType());
        self::assertEquals('content.name', $configuration->getSort('name')->getType());
        self::assertEquals('content.date_published', $configuration->getSort('date_published')->getType());
        self::assertEquals('aggregate', $configuration->getSort('aggregate')->getType());
        self::assertEquals(2, $configuration->getHeadlineCount());
    }

    public function testTaxonomyEntryDefinition(): void
    {
        $configuration = $this->manager->getDefinition(TaxonomyEntryDefinition::class, 'tag');
        self::assertInstanceOf(TaxonomyEntryDefinition::class, $configuration);
        self::assertTrue($configuration->hasField('title'));
        self::assertEquals('string', $configuration->getField('title')->getType());
        self::assertTrue($configuration->getField('title')->isRequired());
        self::assertEquals(100, $configuration->getField('title')->getOptions()->get('maxLength'));
    }

    public function testRecordDefinition(): void
    {
        $configuration = $this->manager->getDefinition(RecordDefinition::class, 'article');
        self::assertInstanceOf(RecordDefinition::class, $configuration);
        self::assertTrue($configuration->hasSource('content'));
        self::assertEquals('content("article")', $configuration->getSource('content'));
        self::assertTrue($configuration->hasAttribute('id'));
        self::assertTrue($configuration->hasAttribute('title'));
        self::assertEquals('content.fields.title', $configuration->getAttribute('title'));
    }
}
