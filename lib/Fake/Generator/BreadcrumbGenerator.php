<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Breadcrumb;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BreadcrumbGenerator extends AbstractGenerator
{
    public function __construct(
        protected LinkGenerator $linkGenerator,
        FakerGenerator          $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(?int $count = null): Breadcrumb
    {
        return Breadcrumb::createLazyGhost(function (Breadcrumb $instance) use ($count) {
            $count = $count ?? $this->fakerGenerator->randomDigitNot(0);
            for ($i = 0; $i < $count; ++$i) {
                $instance->add(($this->linkGenerator)());
            }
        });
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('count')
            ->default(null)
            ->allowedTypes('int', 'null');
    }
}
