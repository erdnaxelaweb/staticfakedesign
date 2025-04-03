<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FloatFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class FloatFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private FloatFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): FloatFieldGenerator
    {
        return new FloatFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $float = ($this->generator)(10, 50);
        self::assertGreaterThanOrEqual(10, $float);
        self::assertLessThanOrEqual(50, $float);
    }
}
