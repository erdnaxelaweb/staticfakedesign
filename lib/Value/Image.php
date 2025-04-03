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

class Image implements MediaInterface
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
}
