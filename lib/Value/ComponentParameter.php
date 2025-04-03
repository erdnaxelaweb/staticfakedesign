<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use JsonSerializable;

class ComponentParameter implements JsonSerializable
{
    public function __construct(
        protected readonly string                 $name,
        protected readonly string                 $label,
        protected readonly bool                   $required,
        protected readonly ComponentParameterType $type,
        protected readonly bool                   $hasDefaultValue,
        protected readonly mixed                  $defaultValue
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label ?? $this->name;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getType(): ComponentParameterType
    {
        return $this->type;
    }

    public function hasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function jsonSerialize(): mixed
    {
        return $this->defaultValue;
    }
}
