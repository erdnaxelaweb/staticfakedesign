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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\IntegerAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class IntegerAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private IntegerAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): IntegerAttributeGenerator
    {
        return new IntegerAttributeGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $int = ($this->generator)(10, 50);
        self::assertGreaterThanOrEqual(10, $int);
        self::assertLessThanOrEqual(50, $int);
    }
}
