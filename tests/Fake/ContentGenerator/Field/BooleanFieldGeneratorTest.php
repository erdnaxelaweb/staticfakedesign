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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\BooleanFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class BooleanFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): BooleanFieldGenerator
    {
        return new BooleanFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $bool = $generator();
        self::assertIsBool($bool);
    }
}
