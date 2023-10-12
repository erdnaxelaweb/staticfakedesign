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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TimeFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class TimeFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): TimeFieldGenerator
    {
        return new TimeFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $time = $generator();
        self::assertIsInt($time);
        self::assertGreaterThanOrEqual(0, $time);
        self::assertLessThanOrEqual(24 * 60 * 60, $time);
    }
}
