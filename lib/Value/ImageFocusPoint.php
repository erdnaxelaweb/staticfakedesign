<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class ImageFocusPoint
{
    public function __construct(
        public readonly float $posX = 0.0,
        public readonly float $posY = 0.0
    ) {
    }
}
