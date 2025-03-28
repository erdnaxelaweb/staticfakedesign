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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentParameterTypeParser;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RecordGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Record\RecordBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\RecordConfigurationManagerTest;
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
            RecordConfigurationManagerTest::getManager(),
            new RecordBuilder(),
            ChainGeneratorTest::getGenerator(),
            new ComponentParameterTypeParser(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();
        $record = $generator('article');

        self::assertInstanceOf(Record::class, $record);
        self::assertArrayHasKey('id', $record);
        self::assertIsInt($record->id);
        self::assertArrayHasKey('title', $record);
    }
}
