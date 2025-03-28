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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Record;

use ErdnaxelaWeb\StaticFakeDesign\Record\RecordBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use ErdnaxelaWeb\StaticFakeDesign\Value\Record;
use PHPUnit\Framework\TestCase;

class RecordBuilderTest extends TestCase
{
    public function testBuild()
    {
        $contentGenerator = ContentGeneratorTest::getGenerator();
        $builder = new RecordBuilder();

        $record = $builder(
            (object) [
                'content' => $contentGenerator('article'),
            ],
            [
                'id' => 'content.id',
                'title' => 'content.fields.title',
                'tags' => 'content.fields.tags[*].fields.title',
            ]
        );

        self::assertInstanceOf(Record::class, $record);
    }
}
