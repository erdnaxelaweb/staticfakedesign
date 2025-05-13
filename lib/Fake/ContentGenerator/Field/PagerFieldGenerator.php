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
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\PagerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use ErdnaxelaWeb\StaticFakeDesign\Value\Pager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagerFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator,
        protected PagerGenerator $pagerGenerator
    ) {
    }

    /**
     * @param array<string, mixed>  $context
     *
     * @return Pager<Content>
     */
    public function __invoke(string $type, array $context = []): Pager
    {
        return ($this->pagerGenerator)($type);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
                        ->required()
                        ->allowedTypes('string');

        $optionsResolver->define('context')
                        ->default([])
                        ->allowedTypes('array');
    }
}
