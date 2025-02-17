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

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Exception\VariationConfigurationNotFoundException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageConfiguration
{
    public const FORCE_WEBP = 'force';

    protected array $breakpoints = [];

    protected array $variations = [];

    public function __construct(array $configuration)
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefault('breakpoints', function(OptionsResolver  $breakpointsOptionsResolver): void {
            $breakpointsOptionsResolver->setPrototype(true);
            $breakpointsOptionsResolver->define('suffix')->required()->allowedTypes('string');
            $breakpointsOptionsResolver->define('media')->required()->allowedTypes('string');
            $breakpointsOptionsResolver->define('use_webp')->default(true)->allowedValues(true, false, self::FORCE_WEBP);
        });
        $optionsResolver->define('variations')->default( [])->allowedTypes('array');

        $configuration = $optionsResolver->resolve($configuration);
        $this->breakpoints = $configuration['breakpoints'];
        $this->variations = $configuration['variations'];
    }

    public function setBreakpoints(array $breakpoints): void
    {
        $this->breakpoints = $breakpoints;
    }

    public function setVariations(array $variations): void
    {
        $this->variations = $variations;
    }

    public function getBreakpoints(): array
    {
        return $this->breakpoints;
    }

    public function getVariationConfig(string $variationName): array
    {
        if (! isset($this->variations[$variationName])) {
            throw new VariationConfigurationNotFoundException($variationName);
        }
        $sizes = $this->variations[$variationName];
        $config = [];

        foreach ($sizes as $i => $size) {
            $breakpoint = $this->breakpoints[$i];
            if($breakpoint['use_webp'] !== self::FORCE_WEBP) {
                $config[] = [
                    'suffix' => $breakpoint['suffix'],
                    'width' => $size[0],
                    'height' => $size[1],
                    'media' => $breakpoint['media'],
                ];
            }
            if(in_array($breakpoint['use_webp'], [true, self::FORCE_WEBP])) {
                $config[] = [
                    'suffix' => $breakpoint['suffix'].'_webp',
                    'width' => $size[0],
                    'height' => $size[1],
                    'media' => $breakpoint['media'],
                ];
            }
        }

        return $config;
    }
}
