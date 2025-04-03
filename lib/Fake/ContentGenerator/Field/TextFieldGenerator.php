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

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\TextFieldValue;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function __invoke(int $max = 10): TextFieldValue
    {
        $count = rand(1, $max);
        $paragraphes = $this->fakerGenerator->paragraphs($count);

        return new TextFieldValue(implode(PHP_EOL, $paragraphes));
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('max')
            ->default(10)
            ->allowedTypes('int');
    }
}
