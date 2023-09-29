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

declare(strict_types=1);

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
