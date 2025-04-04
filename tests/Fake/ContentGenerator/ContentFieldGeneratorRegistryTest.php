<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

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
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\SvgFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\TaxonomyEntryFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\TextFieldGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field\TimeFieldGeneratorTest;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ContentFieldGeneratorRegistryTest extends TestCase
{
    private FieldGeneratorRegistry $registry;

    protected function setUp(): void
    {
        $this->registry = self::getRegistry();
    }

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
                "svg" => SvgFieldGeneratorTest::getGenerator(),
                "taxonomy_entry" => TaxonomyEntryFieldGeneratorTest::getGenerator(),
                "text" => TextFieldGeneratorTest::getGenerator(),
                "time" => TimeFieldGeneratorTest::getGenerator(),
            ]);
        }) extends FieldGeneratorRegistry {
            protected ?FieldGeneratorRegistry $instance = null;

            /**
             * @param callable(): FieldGeneratorRegistry $initializer
             */
            public function __construct(
                protected $initializer
            ) {
                parent::__construct();
            }

            public function getInstance(): FieldGeneratorRegistry
            {
                if (!$this->instance) {
                    $this->instance = ($this->initializer)();
                }
                return $this->instance;
            }

            public function getGenerator(string $type): FieldGeneratorInterface
            {
                return $this->getInstance()
                    ->getGenerator($type);
            }

            public function getTypes(): array
            {
                return $this->getInstance()
                    ->getTypes();
            }
        };
    }

    public function testGetGenerator(): void
    {
        $generator = $this->registry->getGenerator('string');
        self::assertInstanceOf(GeneratorInterface::class, $generator);
    }

    public function testGetGeneratorException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->registry->getGenerator('notfound');
    }
}
