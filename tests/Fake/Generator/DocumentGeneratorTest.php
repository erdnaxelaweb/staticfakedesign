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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\DocumentGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Document\DocumentBuilderTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class DocumentGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): DocumentGenerator
    {
        return new DocumentGenerator(
            DefinitionManagerTest::getManager(),
            DocumentBuilderTest::getBuilder(),
            ContentGeneratorTest::getGenerator(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator(): void
    {
        $generator = self::getGenerator();
        $document = $generator('article');

        self::assertObjectHasProperty('id', $document->fields);
        self::assertIsInt($document->fields->id);
        self::assertObjectHasProperty('title', $document->fields);
        self::assertEquals('test article', $document->fields->title);
    }
}
