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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\StringFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class StringFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;
    public static function getGenerator(  ): StringFieldGenerator
    {
        return new StringFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $string = $generator();
        self::assertIsString($string);

        $string = $generator(200);
        self::assertIsString($string);
        self::assertLessThanOrEqual(200, strlen($string));
    }
}
