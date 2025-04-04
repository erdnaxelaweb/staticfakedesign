<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

class ImageVariationSourceDefinition
{
    public function __construct(
        protected readonly string $suffix,
        protected readonly ?int    $width,
        protected readonly ?int    $height,
        protected readonly string $media,
    ) {
    }

    public function getSuffix(): string
    {
        return $this->suffix;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getMedia(): string
    {
        return $this->media;
    }
}
