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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\RichTextFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\RichTextGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class RichTextFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): RichTextFieldGenerator
    {
        return new RichTextFieldGenerator(RichTextGeneratorTest::getGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $richtext = $generator();
        self::assertIsString($richtext);
    }
}
