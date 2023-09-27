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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use ErdnaxelaWeb\StaticFakeDesign\Value\ImageSource;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageGenerator extends AbstractGenerator
{

    public function __construct( protected ImageConfiguration $imageConfiguration, FakerGenerator $fakerGenerator )
    {
        parent::__construct( $fakerGenerator );
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('variationName')
            ->default(null)
            ->allowedTypes('string', 'null')
            ->info('Name of the image variation to generate. See erdnaxelaweb.static_fake_design.image.variations parameter');

    }

    public function __invoke(string $variationName): Image
    {
        $variationConfig = $this->imageConfiguration->getVariationConfig( $variationName );

        $sources = [];
        foreach ( $variationConfig as $sourceReqs )
        {
            $width = !empty( $sourceReqs['width'] ) ? $sourceReqs['width'] : $this->fakerGenerator->numberBetween(
                100,
                1000
            );
            $height = !empty( $sourceReqs['height'] ) ? $sourceReqs['height'] : $this->fakerGenerator->numberBetween(
                3,
                1000
            );

            $uris = [
                $this->fakerGenerator->imagePlaceholder( $width, $height ),
                $this->fakerGenerator->imagePlaceholder( $width * 2, $height * 2 ) . ' 2x',
            ];
            $sources[] = new ImageSource(
                implode( ', ', $uris ),
                $sourceReqs['media'],
                $width,
                $height,
                null,
                null,
                $sourceReqs['suffix']
            );
        }

        return new Image(
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->sentence(),
            $sources,
        );
    }
}
