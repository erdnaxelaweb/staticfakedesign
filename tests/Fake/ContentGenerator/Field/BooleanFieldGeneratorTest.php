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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\BooleanFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class BooleanFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private BooleanFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): BooleanFieldGenerator
    {
        return new BooleanFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $bool = ($this->generator)();
        $this->expectNotToPerformAssertions();
    }
}
