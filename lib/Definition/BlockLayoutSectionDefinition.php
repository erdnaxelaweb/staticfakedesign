<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

/**
 * Class representing a block layout section configuration.
 */
class BlockLayoutSectionDefinition extends AbstractLazyDefinition
{
    /**
     * @param string        $template The template to use for this section
     * @param array<string> $blocks   Array of blocksIdentifier in the section
     */
    public function __construct(
        string                  $identifier,
        private readonly string $template,
        private readonly array  $blocks = []
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
