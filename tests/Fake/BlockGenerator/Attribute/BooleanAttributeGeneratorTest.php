<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\BooleanAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class BooleanAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private BooleanAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): BooleanAttributeGenerator
    {
        return new BooleanAttributeGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $bool = ($this->generator)();
        $this->expectNotToPerformAssertions();
    }
}
