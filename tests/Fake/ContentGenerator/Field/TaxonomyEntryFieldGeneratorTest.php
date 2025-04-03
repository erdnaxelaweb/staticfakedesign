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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TaxonomyEntryFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\TaxonomyEntryGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use PHPUnit\Framework\TestCase;

class TaxonomyEntryFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    private TaxonomyEntryFieldGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = self::getGenerator();
    }

    public static function getGenerator(): TaxonomyEntryFieldGenerator
    {
        return new TaxonomyEntryFieldGenerator(TaxonomyEntryGeneratorTest::getGenerator());
    }

    public function testGenerator(): void
    {
        $taxonomy = ($this->generator)('tag');
        self::assertInstanceOf(TaxonomyEntry::class, $taxonomy);

        $taxonomies = ($this->generator)('tag', 5);
        self::assertIsArray($taxonomies);
        self::assertNotEmpty($taxonomies);
        self::assertInstanceOf(TaxonomyEntry::class, $taxonomies[0]);
    }
}
