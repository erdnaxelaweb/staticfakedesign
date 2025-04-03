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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TextFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class TextFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private TextFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): TextFieldGenerator
    {
        return new TextFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $text = ($this->generator)();
        self::assertGreaterThan(0, strlen($text->rawText));
        self::assertGreaterThan(0, strlen((string) $text));
    }
}
