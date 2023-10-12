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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractGenerator implements GeneratorInterface
{
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
    }

    /**
     * @param \Faker\Generator $fakerGenerator
     */
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }
}
