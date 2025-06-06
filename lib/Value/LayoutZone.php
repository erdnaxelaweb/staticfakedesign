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

class LayoutZone
{
    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\Block[] $blocks
     */
    public function __construct(
        public readonly mixed $id,
        public readonly array $blocks = []
    ) {
    }
}
