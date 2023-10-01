<?php

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('max')
            ->default(10)
            ->allowedTypes('int');
    }

    public function __invoke(int $max = 10): string
    {
        $count = rand(1, $max);
        $paragraphes = $this->fakerGenerator->paragraphs($count);

        return sprintf('<p>%s</p>', implode('<br/>', $paragraphes));
    }
}
