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

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\UrlAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class UrlAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private UrlAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): UrlAttributeGenerator
    {
        return new UrlAttributeGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $url = ($this->generator)();
        self::assertStringContainsString('http', $url);
    }
}
