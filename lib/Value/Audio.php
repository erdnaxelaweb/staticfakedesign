<?php

/**
 * @copyright Novactive
 * Date: 18/07/2022
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class Audio implements MediaInterface
{
    public function __construct(
        public readonly string       $title,
        public readonly ?Image       $image = null,
        public readonly ?AudioSource $source = null
    ) {
    }

    public function getMediaType(): string
    {
        return 'audio';
    }

    public function hasSource(): bool
    {
        return ! empty($this->source);
    }

    public function isExternalAudio(): bool
    {
        return $this->source instanceof ExternalAudioSource;
    }
}
