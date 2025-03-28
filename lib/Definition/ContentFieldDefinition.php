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

/**
 * Class representing a content field definition.
 */
class ContentFieldDefinition extends AbstractLazyDefinition
{
    public function __construct(
        string                             $identifier,
        private readonly string            $type,
        private readonly bool              $required,
        private readonly mixed             $value,
        private readonly DefinitionOptions $options,
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
}
