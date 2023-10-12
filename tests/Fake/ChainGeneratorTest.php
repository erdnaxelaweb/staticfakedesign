<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ImageGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\MethodInvokerTrait;
use PHPUnit\Framework\TestCase;

class ChainGeneratorTest extends TestCase
{
    use MethodInvokerTrait;
    use GeneratorTestTrait;

    public function testGenerator()
    {
        $fakerGenerator = self::getFakerGenerator();
        $imageGenerator = ImageGeneratorTest::getGenerator();
        $generator = new ChainGenerator($fakerGenerator, [
            'image' => $imageGenerator,
        ]);

        $sentence = $generator->generateFake('sentence');
        self::assertNotEquals('sentence', $sentence);

        $sentence = $generator->generateFake('sentence', [1]);
        self::assertNotEquals('sentence', $sentence);

        $sentences = $generator->generateFakeArray(null, 'sentence');
        self::assertIsArray($sentences);
        self::assertNotEmpty($sentences);
        self::assertIsString($sentences[0]);

        $sentences = $generator->generateFakeArray(10, 'sentence');
        self::assertIsArray($sentences);
        self::assertCount(10, $sentences);
        self::assertIsString($sentences[0]);
        self::assertIsString($sentences[1]);
    }
}
