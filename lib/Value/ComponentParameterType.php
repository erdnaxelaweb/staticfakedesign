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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class ComponentParameterType
{
    public function __construct(
        protected readonly string $expression,
        protected readonly string $type,
        protected readonly array  $parameters,
        protected readonly bool   $isArray,
        protected readonly ?int   $arraySize,
    ) {
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function isArray(): bool
    {
        return $this->isArray;
    }

    public function getArraySize(): ?int
    {
        return $this->arraySize;
    }

    public function __toString(): string
    {
        return $this->expression;
    }
}
