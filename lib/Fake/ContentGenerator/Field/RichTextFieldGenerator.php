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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @phpstan-import-type allowedTags from \ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator
 */
class RichTextFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected RichTextGenerator $richTextGenerator
    ) {
    }

    /**
     * @param array<allowedTags> $allowedTags
     */
    public function __invoke(int $maxWidth = 10, array $allowedTags = []): string
    {
        return ($this->richTextGenerator)($maxWidth, $allowedTags);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('maxWidth')
            ->default(10)
            ->allowedTypes('int');

        $optionsResolver->define('allowedTags')
            ->default([])
            ->allowedTypes('string[]')
            ->info(implode(', ', RichTextGenerator::ALLOWED_TAGS));
    }
}
