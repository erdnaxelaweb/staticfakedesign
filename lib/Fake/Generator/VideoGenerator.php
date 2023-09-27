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
use ErdnaxelaWeb\StaticFakeDesign\Value\Video;
use ErdnaxelaWeb\StaticFakeDesign\Value\VideoSource;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoGenerator extends AbstractGenerator
{

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator $imageGenerator
     */
    public function __construct( protected ImageGenerator $imageGenerator, protected RichTextGenerator $richTextGenerator, FakerGenerator $fakerGenerator )
    {
        parent::__construct( $fakerGenerator );
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('imageVariationName')
            ->default(null)
            ->allowedTypes('string', 'null')
            ->info('Name of the image variation to generate. See erdnaxelaweb.static_fake_design.image.variations parameter');

    }

    public function __invoke(string $imageVariationName = null): Video
    {
        $image = null;
        if ( !empty( $imageVariationName ) )
        {
            $image = ($this->imageGenerator)( $imageVariationName );
        }

        $source = new VideoSource(

            $this->fakerGenerator->sentence(),
            'video/mp4',
            'https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4',

        );

        return new Video(
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->randomNumber( 2, true ),
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->sentence(),
            ($this->richTextGenerator)(),
            $image,
            [ $source ],
        );
    }
}
