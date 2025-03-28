<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

use InvalidArgumentException;

/**
 * Class representing a taxonomy entry definition.
 */
class TaxonomyEntryDefinition extends AbstractLazyDefinition
{
    /**
     * @param array<string, ContentFieldDefinition> $fields Array of field definitions
     * @param array<mixed>                          $models Array of model data used when generating content
     */
    public function __construct(
        string                 $identifier,
        private readonly array $fields,
        private readonly array $models = []
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

    public function hasField(string $name): bool
    {
        return array_key_exists($name, $this->fields);
    }

    public function getField(string $name): ContentFieldDefinition
    {
        if (! $this->hasField($name)) {
            throw new InvalidArgumentException("Field \"$name\" does not exist.");
        }
        return $this->fields[$name];
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
