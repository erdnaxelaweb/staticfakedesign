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

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

class ImageVariationSourceDefinition
{
    public function __construct(
        private readonly string $suffix,
        private readonly int    $width,
        private readonly int    $height,
        private readonly string $media,
    ) {
    }

    public function getSuffix(): string
    {
        return $this->suffix;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getMedia(): string
    {
        return $this->media;
    }
}
