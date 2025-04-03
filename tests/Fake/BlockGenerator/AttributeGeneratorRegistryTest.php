<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\AttributeGeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\AttributeGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\BooleanAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\ContentAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\IntegerAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\RichTextAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\SelectionAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\StringAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\TextAttributeGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute\UrlAttributeGeneratorTest;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AttributeGeneratorRegistryTest extends TestCase
{
    private AttributeGeneratorRegistry $registry;

    protected function setUp(): void
    {
        $this->registry = self::getRegistry();
    }

    public static function getRegistry(): AttributeGeneratorRegistry
    {
        return new class(function () {
            return new AttributeGeneratorRegistry([
                "boolean" => BooleanAttributeGeneratorTest::getGenerator(),
                "content" => ContentAttributeGeneratorTest::getGenerator(),
                "integer" => IntegerAttributeGeneratorTest::getGenerator(),
                "richtext" => RichTextAttributeGeneratorTest::getGenerator(),
                "selection" => SelectionAttributeGeneratorTest::getGenerator(),
                "string" => StringAttributeGeneratorTest::getGenerator(),
                "text" => TextAttributeGeneratorTest::getGenerator(),
                "url" => UrlAttributeGeneratorTest::getGenerator(),
            ]);
        }) extends AttributeGeneratorRegistry {
            protected ?AttributeGeneratorRegistry $instance = null;

            /**
             * @param callable(): AttributeGeneratorRegistry $initializer
             */
            public function __construct(
                protected $initializer
            ) {
                parent::__construct();
            }

            public function getInstance(): AttributeGeneratorRegistry
            {
                if (!$this->instance) {
                    $this->instance = ($this->initializer)();
                }
                return $this->instance;
            }

            public function getGenerator(string $type): AttributeGeneratorInterface
            {
                return $this->getInstance()
                    ->getGenerator($type);
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
