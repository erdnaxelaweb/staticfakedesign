<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Value;


class Image implements MediaInterface
{
    /**
     * @param string|null $alt
     * @param string|null $caption
     * @param string|null $credits
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\ImageSource[] $sources
     */
    public function __construct(
        public readonly ?string $alt,
        public readonly ?string $caption,
        public readonly ?string $credits,
        public readonly array   $sources = []
    )
    {
    }


    /**
     * @return string
     */
    public function getMediaType(): string
    {
        return 'image';
    }

    /**
     * @return ImageSource
     */
    public function getDefaultSource(): ?ImageSource
    {
        $sources = array_values($this->sources);
        return $this->hasSource() ? reset( $sources ) : null;
    }

    public function hasSource(): bool
    {
        return !empty( $this->sources );
    }
}
