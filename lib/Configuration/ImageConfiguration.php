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

class ImageConfiguration
{
    protected array $breakpoints = [];

    protected array $variations = [];

    public function __construct(array $breakpoints, array $variations)
    {
        $this->breakpoints = $breakpoints;
        $this->variations = $variations;
    }

    public function setBreakpoints(array $breakpoints): void
    {
        $this->breakpoints = $breakpoints;
    }

    public function setVariations(array $variations): void
    {
        $this->variations = $variations;
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
            $config[] = [
                'suffix' => $breakpoint['suffix'],
                'width' => $size[0],
                'height' => $size[1],
                'media' => $breakpoint['media'],
            ];
        }

        return $config;
    }
}
