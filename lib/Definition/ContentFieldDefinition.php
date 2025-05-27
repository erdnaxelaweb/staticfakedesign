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
 * Class representing a content field definition.
 */
class ContentFieldDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'content_field';

    /**
     * @param array<int, string[]>                                                     $relations
     */
    public function __construct(
        string                             $identifier,
        protected readonly string            $type,
        protected readonly bool              $required,
        protected readonly mixed             $value,
        protected readonly DefinitionOptions $options,
        protected array $relations
    ) {
        parent::__construct($identifier);
    }

    /**
     * Get the field type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Check if the field is required.
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Get the forced value (if any).
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get the field options.
     */
    public function getOptions(): DefinitionOptions
    {
        return $this->options;
    }

    public function hasOption(string $option): bool
    {
        return $this->options->containsKey($option);
    }

    public function getOption(string $option): mixed
    {
        return $this->options->get($option);
    }

    /**
     * Return an array where the index is the relation type and the value the possible destination content types
     *
     * @return array<int, string[]>
     */
    public function getRelations(): array
    {
        return $this->relations;
    }
}
