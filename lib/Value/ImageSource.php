<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

/**
 * @property-read string $uri
 */
class ImageSource
{
    /**
     * @param array<string> $uris
     */
    public function __construct(
        public readonly array            $uris,
        public readonly string           $media,
        public readonly ?int             $width = null,
        public readonly ?int             $height = null,
        public readonly ?int             $fileSize = null,
        public readonly ?ImageFocusPoint $focusPoint = null,
        public readonly ?string          $mimeType = null,
        public readonly ?string          $variation = null
    ) {
    }

    public function getUri(): string
    {
        return implode(', ', $this->uris);
    }

    /**
     * @param array<string, mixed> $attrs
     *
     * @return array<string, mixed>
     */
    public function getTagAttributes(array $attrs = []): array
    {
        $this->initiateArrayAttribute($attrs, 'srcset');
        $this->initiateArrayAttribute($attrs, 'class');
        $attrs['class'][] = 'enhancedimage--img--lazyload';
        if ($this->focusPoint) {
            $attrs['data-focus-x'] = $this->focusPoint->posX;
            $attrs['data-focus-y'] = $this->focusPoint->posY;
            $attrs['class'][] = 'enhancedimage--focused-img';
        }
        $attrs['srcset'] = $this->getUri();
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

    /**
     * @param array<string, mixed> $attributes
     */
    protected function initiateArrayAttribute(array &$attributes, string $attributeName): void
    {
        if (!isset($attributes[$attributeName])) {
            $attributes[$attributeName] = [];
        } else {
            $attributes[$attributeName] = !is_array($attributes[$attributeName]) ?
                [$attributes[$attributeName]] :
                $attributes[$attributeName];
        }
    }
}
