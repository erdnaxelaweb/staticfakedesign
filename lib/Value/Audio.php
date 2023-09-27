<?php

/**
 * @copyright Novactive
 * Date: 18/07/2022
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class Audio implements MediaInterface
{
    /**
     * @param string $title
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\Image|null $image
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\AudioSource|null $source
     */
    public function __construct(
        public readonly string       $title,
        public readonly ?Image       $image = null,
        public readonly ?AudioSource $source = null
    )
    {
    }

    /**
     * @return string
     */
    public function getMediaType(): string
    {
        return 'audio';
    }

    public function hasSource(): bool
    {
        return !empty( $this->source );
    }

    public function isExternalAudio(): bool
    {
        return $this->source instanceof ExternalAudioSource;
    }
}
