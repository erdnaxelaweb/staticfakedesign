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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected ContentGenerator $contentGenerator
    ) {
    }

    /**
     * @param string|string[] $type
     *
     * @return Content[]|Content
     */
    public function __invoke(string|array $type, int $max = 1): array|Content
    {
        if ($max === 1) {
            return ($this->contentGenerator)($type);
        }

        $contents = [];
        $count = rand(1, $max);
        for ($i = 0; $i < $count; ++$i) {
            $contents[] = ($this->contentGenerator)($type);
        }

        return $contents;
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string', 'string[]');

        $optionsResolver->define('max')
            ->default(1)
            ->allowedTypes('int');
    }
}
