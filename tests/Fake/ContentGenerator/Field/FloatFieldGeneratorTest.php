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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FloatFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class FloatFieldGeneratorTest extends TestCase
{

    use GeneratorTestTrait;
    public static function getGenerator(  ): FloatFieldGenerator
    {
        return new FloatFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $float = $generator();
        self::assertIsFloat($float);
        $float = $generator(10,50);
        self::assertIsFloat($float);
        self::assertGreaterThanOrEqual(10, $float);
        self::assertLessThanOrEqual(50, $float);
    }

}
