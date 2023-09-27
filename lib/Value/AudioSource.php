<?php

/**
 * @copyright Novactive
 * Date: 18/07/2022
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Value;


class AudioSource
{
    /**
     * @param string $name
     * @param int $size
     * @param string $type
     * @param string $uri
     */
    public function __construct(
        public readonly string $name,
        public readonly int    $size,
        public readonly string $type,
        public readonly string $uri
    )
    {
    }


}
