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

namespace ErdnaxelaWeb\StaticFakeDesign\Component;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentContextResolverFactory
{
    public function __construct(
        protected ChainGenerator $fakeGenerator
    ) {
    }

    public function __invoke(Component $component): OptionsResolver
    {
        $optionResolver = new OptionsResolver();
        foreach ($component->getParameters() as $parameter) {
            $configurator = $optionResolver->define($parameter->getName());
            if ($parameter->hasDefaultValue()) {
                $configurator->default($parameter->getDefaultValue());
            } elseif ($parameter->isRequired()) {
                $configurator->default(function (Options $options) use ($parameter) {
                    return $this->fakeGenerator->generateFromTypeExpression($parameter->getType());
                });
            }
        }

        return $optionResolver;
    }
}
