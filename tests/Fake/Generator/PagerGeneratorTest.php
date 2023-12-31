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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\PagerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\PagerConfigurationManagerTest;
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
            SearchFormGeneratorTest::getGenerator(),
            LinkGeneratorTest::getGenerator(),
            PagerConfigurationManagerTest::getManager(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $pager = $generator('articles_list', 10);
        self::assertInstanceOf(Pagerfanta::class, $pager);
        self::assertInstanceOf(Content::class, $pager->getCurrentPageResults()[0]);
        self::assertEquals(5, $pager->getMaxPerPage());
        self::assertEquals(10, $pager->getNbPages());
    }
}
