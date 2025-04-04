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
 * Class representing a content definition.
 */
class ContentDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'content';

    /**
     * @param array<string, ContentFieldDefinition> $fields Array of field definitions
     * @param string[]                              $parent Array of possible parent types
     * @param array<mixed>                          $models Array of model data used when generating content
     */
    public function __construct(
        string                 $identifier,
        protected readonly array $fields,
        protected readonly array $parent,
        protected readonly array $models
    ) {
        parent::__construct($identifier);
    }

    /**
     * Get the field definitions.
     *
     * @return array<string, ContentFieldDefinition>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Get a specific field definition by identifier.
     */
    public function getField(string $identifier): ContentFieldDefinition
    {
        if (!$this->hasField($identifier)) {
            throw new InvalidArgumentException("Field \"$identifier\" does not exist.");
        }
        return $this->fields[$identifier];
    }

    public function hasField(string $identifier): bool
    {
        return array_key_exists($identifier, $this->fields);
    }

    /**
     * Get the parent types.
     *
     * @return string[]
     */
    public function getParent(): array
    {
        return $this->parent;
    }

    /**
     * Get the model data.
     *
     * @return array<mixed>
     */
    public function getModels(): array
    {
        return $this->models;
    }
}
