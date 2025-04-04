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

class BlockAttributeDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'block_attribute';

    public function __construct(
        string                             $identifier,
        protected readonly string            $type,
        protected readonly bool              $required,
        protected readonly mixed             $value,
        protected readonly DefinitionOptions $options,
    ) {
        parent::__construct($identifier);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getOptions(): DefinitionOptions
    {
        return $this->options;
    }
}
