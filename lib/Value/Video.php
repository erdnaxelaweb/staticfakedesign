<?php

/**
 * @copyright Novactive
 * Date: 18/07/2022
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class Video implements MediaInterface
{
    /**
     * @param string $title
     * @param int $duration
     * @param string|null $caption
     * @param string $credits
     * @param string $transcript
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\Image|null $image
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\VideoSource[] $sources
     */
    public function __construct(
        public readonly string  $title,
        public readonly int     $duration,
        public readonly ?string $caption,
        public readonly string  $credits,
        public readonly string  $transcript,
        public readonly ?Image  $image,
        public readonly array   $sources = []
    )
    {
    }

    public function getMediaType(): string
    {
        return 'video';
    }

    public function getDefaultSource(): ?VideoSource
    {
        $sources = array_values($this->sources);
        return $this->hasSource() ? reset($sources) : null;
    }

    public function hasSource(): bool
    {
        return !empty($this->sources);
    }

    public function getPosterSource(): ?ImageSource
    {
        if ($this->image) {
            return $this->image->getDefaultSource();
        }

        return null;
    }

    public function isExternalVideo(): bool
    {
        return $this->getDefaultSource() instanceof ExternalVideoSource;
    }
}
