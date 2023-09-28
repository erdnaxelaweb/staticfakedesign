<?php

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class Coordinates
{
    /**
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $address = ""
    )
    {
    }

    public function __toString(): string
    {
        return sprintf('%s (%s / %s)', $this->address, $this->latitude, $this->longitude);
    }
}
