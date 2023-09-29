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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\TaxonomyEntryFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\TaxonomyEntryGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use PHPUnit\Framework\TestCase;

class TaxonomyEntryFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): TaxonomyEntryFieldGenerator
    {
        return new TaxonomyEntryFieldGenerator(TaxonomyEntryGeneratorTest::getGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $taxonomy = $generator('tag');
        self::assertInstanceOf(TaxonomyEntry::class, $taxonomy);

        $taxonomies = $generator('tag', 5);
        self::assertIsArray($taxonomies);
        self::assertNotEmpty($taxonomies);
        self::assertInstanceOf(TaxonomyEntry::class, $taxonomies[0]);
    }
}
