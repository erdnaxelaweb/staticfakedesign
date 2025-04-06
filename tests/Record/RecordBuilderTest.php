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

use ErdnaxelaWeb\StaticFakeDesign\Record\RecordBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Value\Record;
use PHPUnit\Framework\TestCase;

class RecordBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $contentGenerator = ContentGeneratorTest::getGenerator();
        $builder = new RecordBuilder();

        $record = $builder(
            (object) [
                'content' => $contentGenerator('article'),
            ],
            [
                'id' => 'content.id',
                'title' => 'content.fields.title',
                'tags' => 'content.fields.tags[*].fields.title',
            ]
        );

        self::assertInstanceOf(Record::class, $record);
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
