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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class RichTextGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): RichTextGenerator
    {
        return new RichTextGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $richtext = $generator();
        self::assertIsString($richtext);

        $richtext = $generator(1);
        self::assertIsString($richtext);

        $richtext = $generator(10, ['p']);
        self::assertIsString($richtext);
    }
}
