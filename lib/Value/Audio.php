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
        return !empty($this->source);
    }

    public function isExternalAudio(): bool
    {
        return $this->source instanceof ExternalAudioSource;
    }
}
