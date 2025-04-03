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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\StringFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class StringFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private StringFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): StringFieldGenerator
    {
        return new StringFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $string = ($this->generator)();
        self::assertGreaterThan(0, strlen($string));

        $string = ($this->generator)(200);
        self::assertLessThanOrEqual(200, strlen($string));
    }
}
