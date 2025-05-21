<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Expression;

use ErdnaxelaWeb\StaticFakeDesign\Expression\ExpressionResolver;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\ContentGeneratorTest;
use PHPUnit\Framework\TestCase;

class ExpressionResolverTest extends TestCase
{
    protected ExpressionResolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = self::getResolver();
    }

    public static function getResolver(): ExpressionResolver
    {
        return new ExpressionResolver();
    }

    public function testResolve(): void
    {
        $contentGenerator = ContentGeneratorTest::getGenerator();
        $source = [
            'content' => $contentGenerator('article'),
        ];

        $value = ($this->resolver)(
            $source,
            'content.id'
        );
        self::assertIsInt($value);

        $value = ($this->resolver)(
            $source,
            'content.fields.title'
        );
        self::assertEquals('test article', $value);

        $value = ($this->resolver)(
            $source,
            'content.fields.tags[*].fields.title'
        );
        self::assertIsArray($value);
        self::assertGreaterThanOrEqual(1, count($value));
        self::assertEquals('test tag', $value[0]);
    }
}
