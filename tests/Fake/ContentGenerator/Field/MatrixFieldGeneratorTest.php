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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\MatrixFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class MatrixFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): MatrixFieldGenerator
    {
        return new MatrixFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $matrix = $generator(['firstCol', 'secondCol']);
        self::assertIsArray($matrix);
        self::assertNotEmpty($matrix);
        self::assertIsArray($matrix[0]);
        self::assertArrayHasKey('firstCol', $matrix[0]);
        self::assertIsString($matrix[0]['firstCol']);
        self::assertArrayHasKey('secondCol', $matrix[0]);
        self::assertIsString($matrix[0]['secondCol']);
    }
}
