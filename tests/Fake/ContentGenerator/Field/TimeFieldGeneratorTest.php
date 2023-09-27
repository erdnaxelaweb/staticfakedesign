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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TimeFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class TimeFieldGeneratorTest extends TestCase
{

    use GeneratorTestTrait;
    public static function getGenerator(  ): TimeFieldGenerator
    {
        return new TimeFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $time = $generator();
        self::assertIsInt($time);
        self::assertGreaterThanOrEqual(0, $time);
        self::assertLessThanOrEqual(24*60*60, $time);
    }

}
