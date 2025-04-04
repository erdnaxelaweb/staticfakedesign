<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGeneratorFactory;
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;
use Faker\Factory;

trait GeneratorTestTrait
{
    public static ?GeneratorInterface $instance = null;

    /**
     * @param array<string, mixed>       $imageProviderParameters
     */
    public static function getFakerGenerator(
        array $imageProviderParameters = [],
        ?string $imageProviderClass = null,
        string $locale = Factory::DEFAULT_LOCALE
    ): FakerGenerator {
        return FakerGeneratorFactory::createGenerator($imageProviderParameters, $imageProviderClass, $locale);
    }
}
