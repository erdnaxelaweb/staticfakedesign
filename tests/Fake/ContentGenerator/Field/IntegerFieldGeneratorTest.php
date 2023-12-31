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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\IntegerFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class IntegerFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): IntegerFieldGenerator
    {
        return new IntegerFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $float = $generator();
        self::assertIsInt($float);

        $float = $generator(10, 50);
        self::assertIsInt($float);
        self::assertGreaterThanOrEqual(10, $float);
        self::assertLessThanOrEqual(50, $float);
    }
}
