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

class File
{
    public function __construct(
        public readonly string  $fileName,
        public readonly ?int    $fileSize,
        public readonly ?string $mimeType,
        public readonly string  $uri
    ) {
    }
}
