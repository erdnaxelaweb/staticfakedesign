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

class DocumentDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'document';
    /**
     * @param array<string, string> $fields
     */
    public function __construct(
        string                 $identifier,
        private readonly string $source,
        private readonly array $fields = []
    ) {
        parent::__construct($identifier);
    }

    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return array<string, string>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function hasField(string $fieldIdentifier): bool
    {
        return array_key_exists($fieldIdentifier, $this->fields);
    }

    public function getField(string $fieldIdentifier): string
    {
        if (!$this->hasField($fieldIdentifier)) {
            throw new \InvalidArgumentException("Field \"$fieldIdentifier\" not found for Document \"{$this->getIdentifier()}\"");
        }

        return $this->fields[$fieldIdentifier];
    }
}
