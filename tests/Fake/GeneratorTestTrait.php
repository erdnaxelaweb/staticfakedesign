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

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGeneratorFactory;
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;
use Faker\Factory;

trait GeneratorTestTrait
{
    public static ?GeneratorInterface $instance = null;

    public static function getFakerGenerator(
        array $imageProviderParameters = [],
        ?string $imageProviderClass = null,
        $locale = Factory::DEFAULT_LOCALE
    ): FakerGenerator {
        return FakerGeneratorFactory::createGenerator($imageProviderParameters, $imageProviderClass, $locale);
    }
}
