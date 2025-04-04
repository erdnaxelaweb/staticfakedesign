<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\LocationFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\CoordinatesGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;
use PHPUnit\Framework\TestCase;

class LocationFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private LocationFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): LocationFieldGenerator
    {
        return new LocationFieldGenerator(CoordinatesGeneratorTest::getGenerator());
    }

    public function testGenerator(): void
    {
        $coordinates = ($this->generator)();
        self::assertInstanceOf(Coordinates::class, $coordinates);
    }
}
