<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RecordGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Record\RecordBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ChainGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Record;
use PHPUnit\Framework\TestCase;

class RecordGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): RecordGenerator
    {
        return new RecordGenerator(
            DefinitionManagerTest::getManager(),
            new RecordBuilder(),
            ChainGeneratorTest::getGenerator(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator(): void
    {
        $generator = self::getGenerator();
        $record = $generator('article');

        self::assertInstanceOf(Record::class, $record);
        self::assertArrayHasKey('id', $record);
        self::assertIsInt($record->get('id'));
        self::assertArrayHasKey('title', $record);
        self::assertEquals('test article', $record->get('title'));
    }
}
