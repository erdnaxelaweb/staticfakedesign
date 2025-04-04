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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\TaxonomyEntryGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\DefinitionManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use PHPUnit\Framework\TestCase;

class TaxonomyEntryGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private TaxonomyEntryGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): TaxonomyEntryGenerator
    {
        return new TaxonomyEntryGenerator(
            DefinitionManagerTest::getManager(),
            self::getFakerGenerator(),
            ContentFieldGeneratorRegistryTest::getRegistry()
        );
    }

    public function testGenerator(): void
    {
        $taxonomyEntry = ($this->generator)('tag');
        self::assertInstanceOf(TaxonomyEntry::class, $taxonomyEntry);
    }
}
