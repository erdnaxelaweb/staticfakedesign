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

class RecordDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'record';
    /**
     * @param array<string, string>  $sources
     * @param array<string, string>  $attributes
     */
    public function __construct(
        string $identifier,
        private readonly array $sources,
        private readonly array $attributes = []
    ) {
        parent::__construct($identifier);
    }

    /**
     * @return array<string, string>
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    public function hasSource(string $source): bool
    {
        return array_key_exists($source, $this->sources);
    }

    public function getSource(string $source): string
    {
        if (!$this->hasSource($source)) {
            throw new \InvalidArgumentException("Source \"$source\" not found for record \"{$this->getIdentifier()}\"");
        }

        return $this->sources[$source];
    }

    /**
     * @return array<string, string>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasAttribute(string $attribute): bool
    {
        return array_key_exists($attribute, $this->attributes);
    }

    public function getAttribute(string $attribute): string
    {
        if (!$this->hasAttribute($attribute)) {
            throw new \InvalidArgumentException("Attribute \"$attribute\" not found for record \"{$this->getIdentifier()}\"");
        }

        return $this->attributes[$attribute];
    }
}
