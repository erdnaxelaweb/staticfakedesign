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
 * Class representing a block definition.
 */
class BlockDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'block';

    /**
     * @param array<string, BlockAttributeDefinition> $attributes Array of attribute definitions
     * @param array<string, string>                   $views      Array of view templates
     * @param array<mixed>                            $models     Array of model data used when generating blocks
     */
    public function __construct(
        string                 $identifier,
        protected readonly array $attributes,
        protected readonly array $views,
        protected readonly array $models
    ) {
        parent::__construct($identifier);
    }

    /**
     * Get the attribute definitions.
     *
     * @return array<string, BlockAttributeDefinition>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get a specific attribute definition by identifier.
     */
    public function getAttribute(string $identifier): BlockAttributeDefinition
    {
        if (!$this->hasAttribute($identifier)) {
            throw new InvalidArgumentException("Attribute \"$identifier\" does not exist.");
        }
        return $this->attributes[$identifier];
    }

    public function hasAttribute(string $identifier): bool
    {
        return array_key_exists($identifier, $this->attributes);
    }

    /**
     * Get a specific view template by identifier.
     */
    public function getView(string $view): string
    {
        if (!$this->hasView($view)) {
            throw new InvalidArgumentException("View \"$view\" does not exist.");
        }
        return $this->views[$view];
    }

    public function hasView(string $view): bool
    {
        return array_key_exists($view, $this->views);
    }

    /**
     * Get the view templates.
     *
     * @return array<string, string> Array of view templates
     */
    public function getViews(): array
    {
        return $this->views;
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
