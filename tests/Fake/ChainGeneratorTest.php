<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ImageGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\MethodInvokerTrait;
use PHPUnit\Framework\TestCase;

class ChainGeneratorTest extends TestCase
{
    use MethodInvokerTrait;
    use GeneratorTestTrait;

    private ChainGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): ChainGenerator
    {
        $fakerGenerator = self::getFakerGenerator();
        return new ChainGenerator($fakerGenerator, true, [
            'image' => ImageGeneratorTest::getGenerator(),
            'content' => ContentGeneratorTest::getGenerator(),
        ]);
    }

    public function testGenerator(): void
    {
        $sentence = $this->generator->generateFake('sentence');
        self::assertNotEquals('sentence', $sentence);

        $sentence = $this->generator->generateFake('sentence', [1]);
        self::assertNotEquals('sentence', $sentence);

        $sentences = $this->generator->generateFakeArray(null, 'sentence');
        self::assertNotEmpty($sentences);
        self::assertIsString($sentences[0]);

        $sentences = $this->generator->generateFakeArray(10, 'sentence');
        self::assertCount(10, $sentences);
        self::assertIsString($sentences[0]);
        self::assertIsString($sentences[1]);
    }
}
