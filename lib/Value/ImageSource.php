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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class ImageSource
{
    public function __construct(
        public readonly string           $uri,
        public readonly string           $media,
        public readonly ?int             $width = null,
        public readonly ?int             $height = null,
        public readonly ?int             $fileSize = null,
        public readonly ?ImageFocusPoint $focusPoint = null,
        public readonly ?string          $mimeType = null,
        public readonly ?string          $variation = null
    ) {
    }

    public function getTagAttributes(array $attrs = []): array
    {
        $this->initiateArrayAttribute($attrs, 'srcset');
        $this->initiateArrayAttribute($attrs, 'class');
        if ($this->focusPoint) {
            $attrs['data-focus-x'] = $this->focusPoint->posX;
            $attrs['data-focus-y'] = $this->focusPoint->posY;
        }
        $attrs['srcset'] = $this->uri;
        $attrs['data-width'] = $this->width;
        $attrs['data-height'] = $this->height;
        $attrs['data-variation'] = $this->variation;
        $attrs['media'] = $this->media;
        if ($this->mimeType) {
            $attrs['type'] = $this->mimeType;
        }
        $attrs['class'] = implode(' ', $attrs['class']);

        return $attrs;
    }

    protected function initiateArrayAttribute(array &$attributes, string $attributeName): void
    {
        if (! isset($attributes[$attributeName])) {
            $attributes[$attributeName] = [];
        } else {
            $attributes[$attributeName] = ! is_array($attributes[$attributeName]) ?
                [$attributes[$attributeName]] :
                $attributes[$attributeName];
        }
    }
}
