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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\LocationFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\CoordinatesGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;
use PHPUnit\Framework\TestCase;

class LocationFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): LocationFieldGenerator
    {
        return new LocationFieldGenerator(CoordinatesGeneratorTest::getGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $coordinates = $generator();
        self::assertInstanceOf(Coordinates::class, $coordinates);
    }
}
