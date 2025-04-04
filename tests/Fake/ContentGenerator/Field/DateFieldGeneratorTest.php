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

use DateTime;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\DateFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class DateFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private DateFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): DateFieldGenerator
    {
        return new DateFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $date = ($this->generator)();
        self::assertInstanceOf(DateTime::class, $date);
    }
}
