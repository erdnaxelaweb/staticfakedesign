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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\MatrixFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class MatrixFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private MatrixFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): MatrixFieldGenerator
    {
        return new MatrixFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $matrix = ($this->generator)(['firstCol', 'secondCol']);
        self::assertNotEmpty($matrix);
        self::assertArrayHasKey('firstCol', $matrix[0]);
        self::assertArrayHasKey('secondCol', $matrix[0]);
    }
}
