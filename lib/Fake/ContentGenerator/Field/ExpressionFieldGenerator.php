<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Expression\ExpressionResolver;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpressionFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(protected ExpressionResolver $expressionResolver, FakerGenerator $fakerGenerator)
    {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(Content $content, string $expression): mixed
    {
        return ($this->expressionResolver)(
            [
                'content' => $content,
            ],
            $expression
        );
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('expression')->required()->allowedTypes('string');
    }
}
