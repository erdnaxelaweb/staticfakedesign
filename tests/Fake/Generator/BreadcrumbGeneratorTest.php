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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BreadcrumbGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Breadcrumb;
use Knp\Menu\MenuItem;
use PHPUnit\Framework\TestCase;

class BreadcrumbGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private BreadcrumbGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): BreadcrumbGenerator
    {
        return new BreadcrumbGenerator(LinkGeneratorTest::getGenerator(), self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $breadcrumb = ($this->generator)();
        self::assertInstanceOf(Breadcrumb::class, $breadcrumb);
        self::assertInstanceOf(MenuItem::class, $breadcrumb[0]);

        $breadcrumb = ($this->generator)(5);
        self::assertInstanceOf(Breadcrumb::class, $breadcrumb);
        self::assertCount(5, $breadcrumb);
        self::assertInstanceOf(MenuItem::class, $breadcrumb[0]);
    }
}
