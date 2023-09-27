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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class RichTextGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(  ): RichTextGenerator
    {
        return new RichTextGenerator(self::getFakerGenerator());
    }

    public function testGenerator(  )
    {
        $generator = self::getGenerator();

        $richtext = $generator();
        self::assertIsString($richtext);
    }
}
