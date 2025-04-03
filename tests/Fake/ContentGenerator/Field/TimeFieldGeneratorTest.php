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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TimeFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class TimeFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private TimeFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): TimeFieldGenerator
    {
        return new TimeFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $time = ($this->generator)();
        self::assertGreaterThanOrEqual(0, $time);
        self::assertLessThanOrEqual(24 * 60 * 60, $time);
    }
}
