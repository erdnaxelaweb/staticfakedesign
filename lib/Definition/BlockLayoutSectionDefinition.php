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

/**
 * Class representing a block layout section configuration.
 */
class BlockLayoutSectionDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'block_layout_section';

    /**
     * @param string        $template The template to use for this section
     * @param array<string> $blocks   Array of blocksIdentifier in the section
     */
    public function __construct(
        string                  $identifier,
        protected readonly string $template,
        protected readonly array  $blocks
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
     * Get the blocksIdentifier.
     *
     * @return array<string>
     */
    public function getBlocksIdentifier(): array
    {
        return $this->blocks;
    }
}
