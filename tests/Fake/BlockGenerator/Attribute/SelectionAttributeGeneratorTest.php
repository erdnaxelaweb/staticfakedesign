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

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\SelectionAttributeGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class SelectionAttributeGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private SelectionAttributeGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): SelectionAttributeGenerator
    {
        return new SelectionAttributeGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $options = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
            'd' => 'D',
        ];
        $selection = ($this->generator)($options);
        self::assertCount(1, $selection);
        self::assertNotEmpty(array_intersect($options, $selection));

        $selection = ($this->generator)($options, true);
        self::assertGreaterThanOrEqual(1, count($selection));
        self::assertNotEmpty(array_intersect($options, $selection));
    }
}
