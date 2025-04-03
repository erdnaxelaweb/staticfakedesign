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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\SearchFormGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\Form\Extension\HttpFoundation\Type\FormTypeHttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SearchFormGeneratorTest extends TypeTestCase
{
    use GeneratorTestTrait;

    private SearchFormGenerator $generator;

    private RequestStack $requestStack;

    protected function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $request = new Request();
        $this->requestStack->push($request);

        $this->generator = self::getGenerator($this->requestStack);
    }

    public static function getGenerator(RequestStack $requestStack): SearchFormGenerator
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addTypeExtension(new FormTypeHttpFoundationExtension(new HttpFoundationRequestHandler()))
            ->getFormFactory();
        return new SearchFormGenerator($requestStack, $formFactory, self::getFakerGenerator());
    }

    public function testCreatesFormWithDefaultFields(): void
    {
        $formView = ($this->generator)();

        static::assertInstanceOf(FormView::class, $formView);
        static::assertArrayHasKey('filters', $formView->children);
        static::assertArrayHasKey('search', $formView->children);
    }

    public function testCreatesFormWithSpecifiedFields(): void
    {
        $fields = [
            'text' => 'text',
            'number' => 'number',
        ];
        $formView = ($this->generator)($fields);

        static::assertInstanceOf(FormView::class, $formView);
        static::assertArrayHasKey('filters', $formView->children);
        static::assertArrayHasKey('text', $formView->children['filters']->children);
        static::assertArrayHasKey('number', $formView->children['filters']->children);
    }

    public function testCreatesFormWithSortOptions(): void
    {
        $sorts = [
            'name' => 'Name',
            'date' => 'Date',
        ];
        $formView = ($this->generator)([], $sorts);

        static::assertInstanceOf(FormView::class, $formView);
        static::assertArrayHasKey('sort', $formView->children);
        static::assertCount(2, $formView->children['sort']->vars['choices']);
    }

    public function testHandlesRequestCorrectly(): void
    {
        $request = new Request([
            'form' => [
                'filters' => [
                    'text' => 'test',
                ],
            ],
        ]);
        $this->requestStack->push($request);

        $fields = [
            'text' => 'text',
        ];
        $formView = ($this->generator)($fields);

        static::assertInstanceOf(FormView::class, $formView);
        static::assertEquals('test', $formView->children['filters']->children['text']->vars['value']);
    }
}
