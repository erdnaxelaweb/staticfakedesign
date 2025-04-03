<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractGenerator implements GeneratorInterface
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected function resolveOptions(array $options): array
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        return $optionsResolver->resolve($options);
    }
}
