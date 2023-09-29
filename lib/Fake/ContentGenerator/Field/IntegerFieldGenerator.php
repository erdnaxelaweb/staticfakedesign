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

class IntegerFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('min')
            ->default(0)
            ->allowedTypes('int');

        $optionResolver->define('max')
            ->default(PHP_INT_MAX)
            ->allowedTypes('int');
    }

    public function __invoke(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return $this->fakerGenerator->numberBetween($min, $max);
    }
}
