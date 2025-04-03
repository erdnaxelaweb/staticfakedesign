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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\CoordinatesGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;
use PHPUnit\Framework\TestCase;

class CoordinatesGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private CoordinatesGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): CoordinatesGenerator
    {
        return new CoordinatesGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $coordinates = ($this->generator)();
        self::assertInstanceOf(Coordinates::class, $coordinates);
    }
}
