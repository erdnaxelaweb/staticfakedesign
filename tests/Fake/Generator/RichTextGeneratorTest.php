<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class RichTextGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private RichTextGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): RichTextGenerator
    {
        return new RichTextGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $richtext = ($this->generator)();
        self::assertNotEmpty($richtext);
    }
}
