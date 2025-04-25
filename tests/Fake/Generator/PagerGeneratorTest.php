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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\PagerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PagerGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private PagerGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): PagerGenerator
    {
        $request = new Request();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        return new PagerGenerator(
            $requestStack,
            ContentGeneratorTest::getGenerator(),
            DocumentGeneratorTest::getGenerator(),
            SearchFormGeneratorTest::getGenerator($requestStack),
            LinkGeneratorTest::getGenerator(),
            DefinitionManagerTest::getManager(),
            self::getFakerGenerator()
        );
    }

    public function testGenerator(): void
    {
        $pager = ($this->generator)('articles_list', 10);
        self::assertInstanceOf(Content::class, $pager->getCurrentPageResults()[0]);
        self::assertEquals(5, $pager->getMaxPerPage());
        self::assertGreaterThanOrEqual(1, $pager->getNbPages());
        self::assertLessThanOrEqual(10, $pager->getNbPages());
    }
}
