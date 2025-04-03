<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Audio;
use ErdnaxelaWeb\StaticFakeDesign\Value\AudioSource;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudioGenerator extends AbstractGenerator
{
    public function __construct(
        protected ImageGenerator $imageGenerator,
        FakerGenerator           $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(string $imageVariationName = null): Audio
    {
        $image = null;
        if (!empty($imageVariationName)) {
            $image = ($this->imageGenerator)($imageVariationName);
        }

        $source = new AudioSource(
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->numberBetween(0, 999999),
            'audio/ogg',
            'https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.ogg',
        );

        return new Audio($this->fakerGenerator->sentence(), $image, $source);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('imageVariationName')
            ->default(null)
            ->allowedTypes('string', 'null')
            ->info(
                'Name of the image variation to generate. See erdnaxelaweb.static_fake_design.image.variations parameter'
            );
    }
}
