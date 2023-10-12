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

class AudioSource
{
    public function __construct(
        public readonly string $name,
        public readonly int    $size,
        public readonly string $type,
        public readonly string $uri
    ) {
    }
}
