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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BreadcrumbGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Breadcrumb;
use Knp\Menu\MenuItem;
use PHPUnit\Framework\TestCase;

class BreadcrumbGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator()
    {
        return new BreadcrumbGenerator(LinkGeneratorTest::getGenerator(), self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $breadcrumb = $generator();
        self::assertInstanceOf(Breadcrumb::class, $breadcrumb);
        self::assertNotEmpty($breadcrumb);
        self::assertInstanceOf(MenuItem::class, $breadcrumb[0]);

        $breadcrumb = $generator(5);
        self::assertInstanceOf(Breadcrumb::class, $breadcrumb);
        self::assertCount(5, $breadcrumb);
        self::assertInstanceOf(MenuItem::class, $breadcrumb[0]);
    }
}
