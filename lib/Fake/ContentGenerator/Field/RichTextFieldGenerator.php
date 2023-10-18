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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RichTextFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected RichTextGenerator $richTextGenerator
    ) {
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

    public function __invoke(int $maxWidth = 10, array $allowedTags = []): string
    {
        return ($this->richTextGenerator)($maxWidth, $allowedTags);
    }
}
