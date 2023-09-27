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

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractGenerator implements GeneratorInterface
{
    public function configureOptions(OptionsResolver $optionResolver): void
    {
    }

    /**
     * @param \Faker\Generator $fakerGenerator
     */
    public function __construct( protected FakerGenerator $fakerGenerator )
    {
    }
}
