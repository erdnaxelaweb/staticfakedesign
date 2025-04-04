<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerFilterDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\PagerFilterDefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator\SearchFormGeneratorTest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PagerFilterDefinitionTransformerTest extends TestCase
{
    private PagerFilterDefinitionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = static::getTransformer();
    }

    public static function getTransformer(): PagerFilterDefinitionTransformer
    {
        $requestStack = new RequestStack();
        $request = new Request();
        $requestStack->push($request);
        return new PagerFilterDefinitionTransformer(SearchFormGeneratorTest::getGenerator($requestStack));
    }

    public function testFromHashTransformsPagerFilterDefinitionCorrectly(): void
    {
        $hash = [
            'identifier' => 'filter1',
            'hash' => [
                'type' => 'text',
                'options' => [
                    'option1' => 'value1',
                ],
            ],
        ];

        $definition = $this->transformer->fromHash($hash);

        static::assertInstanceOf(PagerFilterDefinition::class, $definition);
        static::assertEquals('filter1', $definition->getIdentifier());
        static::assertEquals('text', $definition->getType());
        self::assertEquals('value1', $definition->getOptions()->get('option1'));
    }

    public function testToHashTransformsPagerFilterDefinitionCorrectly(): void
    {
        $definition = new PagerFilterDefinition(
            "filter1",
            'text',
            new DefinitionOptions([
                'option1' => 'value1',
            ])
        );

        $hash = $this->transformer->toHash($definition);

        static::assertEquals([
            'identifier' => 'filter1',
            'hash' => [
                'type' => 'text',
                'options' => [
                    'option1' => 'value1',
                ],
            ],
        ], $hash);
    }
}
