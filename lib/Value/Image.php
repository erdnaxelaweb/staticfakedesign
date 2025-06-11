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

use Serializable;

class Image implements MediaInterface, Serializable
{
    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\ImageSource[] $sources
     */
    public function __construct(
        public readonly ?string $alt,
        public readonly ?string $caption,
        public readonly ?string $credits,
        public readonly array   $sources = []
    ) {
    }

    public function __toString(): string
    {
        return $this->serialize();
    }

    public function __serialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function __unserialize(array $data): void
    {
        $sources = [];
        foreach ($data['sources'] as $source) {
            $focusPoint = isset($source['focusPoint']) ? new ImageFocusPoint(...$source['focusPoint']) : null;
            $sources[] = new ImageSource(
                $source['uris'],
                $source['media'],
                $source['width'] ?? null,
                $source['height'] ?? null,
                $source['fileSize'] ?? null,
                $focusPoint,
                $source['mimeType'] ?? null,
                $source['variation'] ?? null,
            );
        }

        $this->alt = $data['alt'] ?? null;
        $this->caption = $data['caption'] ?? null;
        $this->credits = $data['credits'] ?? null;
        $this->sources = $sources;
    }

    public function getMediaType(): string
    {
        return 'image';
    }

    public function getDefaultSource(): ?ImageSource
    {
        $sources = array_values($this->sources);
        return $this->hasSource() ? reset($sources) : null;
    }

    public function hasSource(): bool
    {
        return !empty($this->sources);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'alt' => $this->alt,
            'caption' => $this->caption,
            'credits' => $this->credits,
            'sources' => array_map(function (ImageSource $source) {
                return $source->toArray();
            }, $this->sources),
        ];
    }

    public function serialize(): string
    {
        return serialize($this);
    }

    public function unserialize(string $data): Image
    {
        return unserialize($data);
    }
}
