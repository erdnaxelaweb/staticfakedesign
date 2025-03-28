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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\SelectionFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class SelectionFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private SelectionFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): SelectionFieldGenerator
    {
        return new SelectionFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $options = ['option1', 'option2', 'option3', 'option4'];

        $selection = ($this->generator)($options);
        self::assertNotEmpty($selection);
        self::assertCount(1, $selection);
        self::assertNotEmpty(array_intersect($selection, $options));

        $selection = ($this->generator)($options, true);
        self::assertNotEmpty($selection);
        self::assertNotEmpty(array_intersect($selection, $options));
    }
}
