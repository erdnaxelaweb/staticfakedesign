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

use DateTime;
use Symfony\Component\VarExporter\LazyGhostTrait;

class Block
{
    use LazyGhostTrait;

    public function __construct(
        public readonly int                       $id,
        public readonly string                    $name,
        public readonly string                    $type,
        public readonly string                    $view,
        public readonly ?string                   $class,
        public readonly ?string                   $style,
        public readonly ?DateTime                 $since,
        public readonly ?DateTime                 $till,
        public readonly bool                      $isVisible,
        public readonly BlockAttributesCollection $attributes,
    ) {
    }
}
