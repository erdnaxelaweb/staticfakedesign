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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\PagerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;

class PagerGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): PagerGenerator
    {
        return new PagerGenerator(
            ContentGeneratorTest::getGenerator(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $pager = $generator('article', 5, 10);
        self::assertInstanceOf(Pagerfanta::class, $pager);
        self::assertInstanceOf(Content::class, $pager->getCurrentPageResults()[0]);
        self::assertEquals(5, $pager->getMaxPerPage());
        self::assertEquals(10, $pager->getNbPages());
    }


}
