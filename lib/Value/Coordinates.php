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

class Coordinates
{
    public function __construct(
        public readonly float  $latitude,
        public readonly float  $longitude,
        public readonly string $address = ""
    ) {
    }

    public function __toString(): string
    {
        return sprintf('%s (%s / %s)', $this->address, $this->latitude, $this->longitude);
    }
}
