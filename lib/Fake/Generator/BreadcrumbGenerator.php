<?php

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BreadcrumbGenerator extends AbstractGenerator
{
    public function __construct(
        protected LinkGenerator $linkGenerator,
        FakerGenerator $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('count')
            ->default(null)
            ->allowedTypes('int', 'null');
    }

    public function __invoke(?int $count = null): array
    {
        $count = $count ?? $this->fakerGenerator->randomDigitNot(0);
        $links = [];
        for ($i = 0; $i < $count; ++$i) {
            $links[] = ($this->linkGenerator)();
        }
        return $links;
    }
}
