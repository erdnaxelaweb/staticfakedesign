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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TextFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class TextFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): TextFieldGenerator
    {
        return new TextFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $text = $generator();
        self::assertIsString($text);
    }
}
