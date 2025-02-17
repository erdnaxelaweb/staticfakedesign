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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FieldGeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\BlocksFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\BooleanFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\ContentFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\DateFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\DateTimeFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\EmailFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\FileFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\FloatFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\ImageFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\IntegerFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\LocationFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\MatrixFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\RichTextFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\SelectionFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\StringFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\TaxonomyEntryFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\TextFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\TimeFieldGeneratorTest;
use PHPUnit\Framework\TestCase;

class ContentFieldGeneratorRegistryTest extends TestCase
{
    public static function getRegistry(): FieldGeneratorRegistry
    {
        return new class(function () {
            return new FieldGeneratorRegistry([
                "blocks" => BlocksFieldGeneratorTest::getGenerator(),
                "boolean" => BooleanFieldGeneratorTest::getGenerator(),
                "content" => ContentFieldGeneratorTest::getGenerator(),
                "date" => DateFieldGeneratorTest::getGenerator(),
                "datetime" => DateTimeFieldGeneratorTest::getGenerator(),
                "email" => EmailFieldGeneratorTest::getGenerator(),
                "file" => FileFieldGeneratorTest::getGenerator(),
                "float" => FloatFieldGeneratorTest::getGenerator(),
                "image" => ImageFieldGeneratorTest::getGenerator(),
                "integer" => IntegerFieldGeneratorTest::getGenerator(),
                "location" => LocationFieldGeneratorTest::getGenerator(),
                "matrix" => MatrixFieldGeneratorTest::getGenerator(),
                "richtext" => RichTextFieldGeneratorTest::getGenerator(),
                "selection" => SelectionFieldGeneratorTest::getGenerator(),
                "string" => StringFieldGeneratorTest::getGenerator(),
                "taxonomy_entry" => TaxonomyEntryFieldGeneratorTest::getGenerator(),
                "text" => TextFieldGeneratorTest::getGenerator(),
                "time" => TimeFieldGeneratorTest::getGenerator(),
            ]);
        }) extends FieldGeneratorRegistry {
            protected ?FieldGeneratorRegistry $instance = null;

            public function __construct(
                protected $initializer
            ) {
            }

            public function getInstance(): FieldGeneratorRegistry
            {
                if (! $this->instance) {
                    $this->instance = ($this->initializer)();
                }
                return $this->instance;
            }

            public function getGenerator(string $type): FieldGeneratorInterface
            {
                return ($this->getInstance())
                    ->getGenerator($type);
            }
        };
    }

    public function testGetGenerator()
    {
        $registry = self::getRegistry();
        $generator = $registry->getGenerator('string');
        self::assertInstanceOf(GeneratorInterface::class, $generator);
    }

    public function testGetGeneratorException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $registry = self::getRegistry();
        $generator = $registry->getGenerator('notfound');
    }
}
