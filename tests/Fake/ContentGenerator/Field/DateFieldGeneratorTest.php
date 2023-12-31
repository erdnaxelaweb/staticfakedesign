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

use DateTime;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\DateFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class DateFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): DateFieldGenerator
    {
        return new DateFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $date = $generator();
        self::assertInstanceOf(DateTime::class, $date);
    }
}
