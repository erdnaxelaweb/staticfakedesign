<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FloatFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('min')
            ->default(0)
            ->allowedTypes('int', 'float');

        $optionsResolver->define('max')
            ->default(PHP_FLOAT_MAX)
            ->allowedTypes('int', 'float');
    }

    public function __invoke(float $min = 0, float $max = PHP_FLOAT_MAX): float
    {
        return $this->fakerGenerator->randomFloat(null, $min, $max);
    }
}
