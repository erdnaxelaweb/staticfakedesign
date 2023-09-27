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

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\CoordinatesGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;
use PHPUnit\Framework\TestCase;

class CoordinatesGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(  )
    {
        return new CoordinatesGenerator(self::getFakerGenerator());
    }

    public function testGenerator(  )
    {
        $generator = self::getGenerator();

        $coordinates = $generator();
        self::assertInstanceOf(Coordinates::class, $coordinates);
    }
}
