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

use Faker\Factory as BaseFactory;
use Faker\Generator;

class FakerGeneratorFactory extends BaseFactory
{
    /**
     * Create a new generator
     *
     * @param array<string, mixed> $imageProviderParameters
     */
    public static function createGenerator(
        array   $imageProviderParameters = [],
        ?string $imageProviderClass = null,
        string  $locale = self::DEFAULT_LOCALE
    ): FakerGenerator {
        $generator = new FakerGenerator($imageProviderParameters);

        foreach (static::$defaultProviders as $provider) {
            $providerClassName = self::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        if ($imageProviderClass) {
            $generator->addProvider(new $imageProviderClass($generator));
        }

        return $generator;
    }
}
