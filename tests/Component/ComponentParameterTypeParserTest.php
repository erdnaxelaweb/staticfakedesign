<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Component;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentParameterTypeParser;
use ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameterType;
use PHPUnit\Framework\TestCase;

class ComponentParameterTypeParserTest extends TestCase
{
    private ComponentParameterTypeParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ComponentParameterTypeParser();
    }

    public function testSimpleType(): void
    {
        $result = $this->parser->fromString('string');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('string', $result->getExpression());
        $this->assertEquals('string', $result->getType());
        $this->assertEquals([], $result->getParameters());
        $this->assertFalse($result->isArray());
        $this->assertNull($result->getArraySize());
    }

    public function testTypeWithParameters(): void
    {
        $result = $this->parser->fromString('faker("firstName")');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('faker("firstName")', $result->getExpression());
        $this->assertEquals('faker', $result->getType());
        $this->assertEquals(['firstName'], $result->getParameters());
        $this->assertFalse($result->isArray());
        $this->assertNull($result->getArraySize());
    }

    public function testTypeWithJsonParameters(): void
    {
        $result = $this->parser->fromString('faker({"method":"firstName","locale":"fr_FR"})');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('faker({"method":"firstName","locale":"fr_FR"})', $result->getExpression());
        $this->assertEquals('faker', $result->getType());
        $this->assertEquals([
            'method' => 'firstName',
            'locale' => 'fr_FR',
        ], $result->getParameters());
        $this->assertFalse($result->isArray());
        $this->assertNull($result->getArraySize());
    }

    public function testArrayType(): void
    {
        $result = $this->parser->fromString('string[]');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('string[]', $result->getExpression());
        $this->assertEquals('string', $result->getType());
        $this->assertEquals([], $result->getParameters());
        $this->assertTrue($result->isArray());
        $this->assertNull($result->getArraySize());
    }

    public function testArrayTypeWithSize(): void
    {
        $result = $this->parser->fromString('faker("firstName")[5]');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('faker("firstName")[5]', $result->getExpression());
        $this->assertEquals('faker', $result->getType());
        $this->assertEquals(['firstName'], $result->getParameters());
        $this->assertTrue($result->isArray());
        $this->assertEquals(5, $result->getArraySize());
    }

    public function testArrayTypeWithZeroSize(): void
    {
        $result = $this->parser->fromString('string[0]');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('string[0]', $result->getExpression());
        $this->assertEquals('string', $result->getType());
        $this->assertEquals([], $result->getParameters());
        $this->assertTrue($result->isArray());
        $this->assertEquals(0, $result->getArraySize());
    }

    public function testComplexTypeWithJsonParametersAndArraySize(): void
    {
        $result = $this->parser->fromString('faker({"method":"word","options":{"min":3,"max":5}})[10]');

        $this->assertInstanceOf(ComponentParameterType::class, $result);
        $this->assertEquals('faker({"method":"word","options":{"min":3,"max":5}})[10]', $result->getExpression());
        $this->assertEquals('faker', $result->getType());
        $this->assertEquals([
            'method' => 'word',
            'options' => [
                'min' => 3,
                'max' => 5,
            ],
        ], $result->getParameters());
        $this->assertTrue($result->isArray());
        $this->assertEquals(10, $result->getArraySize());
    }
}
