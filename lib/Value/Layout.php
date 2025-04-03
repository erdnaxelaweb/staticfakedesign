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

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;

class Layout
{
    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\LayoutZone[] $zones
     * @param array<string, BlockLayoutSectionDefinition>       $sections
     */
    public function __construct(
        public readonly string $template,
        public readonly array  $zones,
        public readonly array  $sections
    ) {
    }

    public function __toString(): string
    {
        return $this->template;
    }
}
