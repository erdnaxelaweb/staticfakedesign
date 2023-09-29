<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BreadcrumbGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
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
        self::assertIsArray($breadcrumb);
        self::assertNotEmpty($breadcrumb);
        self::assertInstanceOf(MenuItem::class, $breadcrumb[0]);

        $breadcrumb = $generator(5);
        self::assertIsArray($breadcrumb);
        self::assertCount(5, $breadcrumb);
        self::assertInstanceOf(MenuItem::class, $breadcrumb[0]);
    }
}
