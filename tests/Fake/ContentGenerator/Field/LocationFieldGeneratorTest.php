<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
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
