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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\TaxonomyEntryGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Configuration\TaxonomyEntryConfigurationManagerTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\ContentFieldGeneratorRegistryTest;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry;
use PHPUnit\Framework\TestCase;

class TaxonomyEntryGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): TaxonomyEntryGenerator
    {
        return new TaxonomyEntryGenerator(
            TaxonomyEntryConfigurationManagerTest::getManager(),
            self::getFakerGenerator(),
            ContentFieldGeneratorRegistryTest::getRegistry()
        );
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();
        $taxonomyEntry = $generator('tag');
        self::assertInstanceOf(TaxonomyEntry::class, $taxonomyEntry);
    }
}
