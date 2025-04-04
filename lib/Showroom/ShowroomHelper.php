<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Showroom;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;

/**
 * @phpstan-import-type breakpoint from ImageConfiguration
 */
class ShowroomHelper
{
    protected bool $previewActive = false;

    public function __construct(
        protected ImageConfiguration $imageConfiguration,
        protected string             $previewLayout,
    ) {
    }

    /**
     * @return array<breakpoint>
     */
    public function getBreakpoints(): array
    {
        return $this->imageConfiguration->getBreakpoints();
    }

    public function isPreviewActive(): bool
    {
        return $this->previewActive;
    }

    public function setPreviewActive(bool $previewActive): void
    {
        $this->previewActive = $previewActive;
    }

    public function getPreviewLayout(): string
    {
        return $this->previewLayout;
    }
}
