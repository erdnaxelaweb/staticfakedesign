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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FileFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\File;
use PHPUnit\Framework\TestCase;

class FileFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private FileFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): FileFieldGenerator
    {
        return new FileFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $file = ($this->generator)();
        self::assertInstanceOf(File::class, $file);
    }
}
