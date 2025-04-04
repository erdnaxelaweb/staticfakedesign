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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Image;
use ErdnaxelaWeb\StaticFakeDesign\Value\ImageFocusPoint;
use ErdnaxelaWeb\StaticFakeDesign\Value\ImageSource;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageGenerator extends AbstractGenerator
{
    public function __construct(
        protected ImageConfiguration $imageConfiguration,
        FakerGenerator               $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(string $variationName, string|int|null $id = null): Image
    {
        $variationConfig = $this->imageConfiguration->getVariationConfig($variationName);

        $sources = [];
        foreach ($variationConfig as $sourceReqs) {
            $width = !empty($sourceReqs->getWidth()) ? $sourceReqs->getWidth() : $this->fakerGenerator->numberBetween(
                100,
                1000
            );
            $height = !empty($sourceReqs->getHeight()) ? $sourceReqs->getHeight(
            ) : $this->fakerGenerator->numberBetween(3, 1000);

            $uris = [
                $this->fakerGenerator->imagePlaceholder($width, $height, $id),
                $this->fakerGenerator->imagePlaceholder($width * 2, $height * 2, $id) . ' 2x',
            ];
            $sources[] = new ImageSource(
                $uris,
                $sourceReqs->getMedia(),
                $width,
                $height,
                null,
                new ImageFocusPoint(0, 0),
                null,
                $sourceReqs->getSuffix()
            );
        }

        return new Image(
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->sentence(),
            $this->fakerGenerator->sentence(),
            $sources,
        );
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('variationName')
            ->default(null)
            ->allowedTypes('string', 'null')
            ->info(
                'Name of the image variation to generate. See erdnaxelaweb.static_fake_design.image.variations parameter'
            );
    }
}
