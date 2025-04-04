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

    private LinkGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): LinkGenerator
    {
        $menuFactory = new MenuFactory();
        $translator = new class() implements TranslatorInterface {
            use TranslatorTrait;
        };
        return new LinkGenerator($menuFactory, $translator, self::getFakerGenerator());
    }

    public function testGenerator(): void
    {
        $link = ($this->generator)();
        self::assertInstanceOf(MenuItem::class, $link);

        $link = ($this->generator)("_blank");
        self::assertInstanceOf(MenuItem::class, $link);
        self::assertEquals('_blank', $link->getLinkAttribute('target'));
    }
}
