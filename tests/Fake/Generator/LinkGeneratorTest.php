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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\LinkGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorTrait;

class LinkGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): LinkGenerator
    {
        $menuFactory = new MenuFactory();
        $translator = new class() implements TranslatorInterface {
            use TranslatorTrait;
        };
        return new LinkGenerator($menuFactory, $translator, self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $link = $generator();
        self::assertInstanceOf(MenuItem::class, $link);

        $link = $generator("_blank");
        self::assertInstanceOf(MenuItem::class, $link);
        self::assertEquals('_blank', $link->getLinkAttribute('target'));
    }
}
