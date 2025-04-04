<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

use InvalidArgumentException;

/**
 * Class representing a block layout definition.
 */
class BlockLayoutDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'block_layout';

    /**
     * @param string                                      $template The template to use for this layout
     * @param string[]                                    $zones    Array of zones in the layout
     * @param array<string, BlockLayoutSectionDefinition> $sections Array of sections in the layout
     */
    public function __construct(
        string                  $identifier,
        protected readonly string $template,
        protected readonly array  $zones,
        protected readonly array  $sections
    ) {
        parent::__construct($identifier);
    }

    /**
     * Get the template.
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Get the zones.
     *
     * @return string[]
     */
    public function getZones(): array
    {
        return $this->zones;
    }

    /**
     * Get the sections.
     *
     * @return array<string, BlockLayoutSectionDefinition>
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * Get a section by identifier.
     *
     * @param string $sectionIdentifier The identifier of the section to get
     *
     * @return BlockLayoutSectionDefinition The section
     */
    public function getSection(string $sectionIdentifier): BlockLayoutSectionDefinition
    {
        if (!$this->hasSection($sectionIdentifier)) {
            throw new InvalidArgumentException("Section \"$sectionIdentifier\" does not exist.");
        }
        return $this->sections[$sectionIdentifier];
    }

    /**
     * Check if a section exists.
     *
     * @param string $sectionIdentifier The identifier of the section to check
     *
     * @return bool True if the section exists, false otherwise
     */
    public function hasSection(string $sectionIdentifier): bool
    {
        return array_key_exists($sectionIdentifier, $this->sections);
    }
}
