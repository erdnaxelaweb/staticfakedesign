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

class ComponentParameterType
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function __construct(
        protected readonly string $expression,
        protected readonly string $type,
        protected readonly array  $parameters,
        protected readonly bool   $isArray,
        protected readonly ?int   $arraySize,
    ) {
    }

    public function __toString(): string
    {
        return $this->expression;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed>
     */
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
}
