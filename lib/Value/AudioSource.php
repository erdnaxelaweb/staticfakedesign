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
