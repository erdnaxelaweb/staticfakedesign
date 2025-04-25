<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Document;

use ErdnaxelaWeb\StaticFakeDesign\Document\DocumentBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Expression\ExpressionResolver;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use PHPUnit\Framework\TestCase;

class DocumentBuilderTest extends TestCase
{
    protected DocumentBuilder $builder;

    public function setUp(): void
    {
        $this->builder = self::getBuilder();
    }

    public static function getBuilder(): DocumentBuilder
    {
        $expressionResolver = new ExpressionResolver();
        return new DocumentBuilder($expressionResolver);
    }

    public function testBuild(): void
    {
        $contentGenerator = ContentGeneratorTest::getGenerator();

        $content = $contentGenerator('article');
        $document = ($this->builder)(
            'article_document',
            $content,
            [
                'id' => 'content.id',
                'title' => 'content.fields.title',
                'image' => 'content.fields.image("large").getDefaultSource().getUri()',
                'tags' => 'content.fields.tags[*].fields.title',
            ],
            $content->mainLanguageCode
        );

        self::assertArrayHasKey('id', $document->fields);
        self::assertIsInt($document->fields['id']);
        self::assertArrayHasKey('title', $document->fields);
        self::assertEquals('test article', $document->fields['title']);
        self::assertArrayHasKey('tags', $document->fields);
        self::assertIsArray($document->fields['tags']);
        self::assertGreaterThanOrEqual(1, count($document->fields['tags']));
        self::assertEquals('test tag', $document->fields['tags'][0]);
        self::assertIsString($document->fields['image']);
    }
}
