<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Record;

use ErdnaxelaWeb\StaticFakeDesign\Expression\ExpressionResolver;
use ErdnaxelaWeb\StaticFakeDesign\Record\RecordBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use PHPUnit\Framework\TestCase;

class RecordBuilderTest extends TestCase
{
    protected RecordBuilder $builder;

    public function setUp(): void
    {
        $this->builder = self::getBuilder();
    }

    public static function getBuilder(): RecordBuilder
    {
        $expressionResolver = new ExpressionResolver();
        return new RecordBuilder($expressionResolver);
    }

    public function testBuild(): void
    {
        $contentGenerator = ContentGeneratorTest::getGenerator();

        $record = ($this->builder)(
            [
                'content' => $contentGenerator('article'),
            ],
            [
                'id' => 'content.id',
                'title' => 'content.fields.title',
                'tags' => 'content.fields.tags[*].fields.title',
            ]
        );

        self::assertArrayHasKey('id', $record);
        self::assertIsInt($record->get('id'));
        self::assertArrayHasKey('title', $record);
        self::assertEquals('test article', $record->get('title'));
        self::assertArrayHasKey('tags', $record);
        self::assertIsArray($record->get('tags'));
        self::assertGreaterThanOrEqual(1, count($record->get('tags')));
        self::assertEquals('test tag', $record->get('tags')[0]);
    }
}
