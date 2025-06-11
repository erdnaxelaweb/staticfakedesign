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

class ImageFocusPoint
{
    public function __construct(
        public readonly float $posX = 0.0,
        public readonly float $posY = 0.0
    ) {
    }

    /**
     * @return array<string, float>
     */
    public function toArry(): array
    {
        return [
            'posX' => $this->posX,
            'posY' => $this->posY,
        ];
    }
}
