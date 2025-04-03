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

class Video implements MediaInterface
{
    /**
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
    ) {
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
        return $this->image?->getDefaultSource();
    }

    public function isExternalVideo(): bool
    {
        return $this->getDefaultSource() instanceof ExternalVideoSource;
    }
}
