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

use DateTime;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\DateTimeFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class DateTimeFieldGeneratorTest extends TestCase
{

    use GeneratorTestTrait;
    public static function getGenerator(  ): DateTimeFieldGenerator
    {
        return new DateTimeFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $date = $generator();
        self::assertInstanceOf( DateTime::class, $date);
    }

}
