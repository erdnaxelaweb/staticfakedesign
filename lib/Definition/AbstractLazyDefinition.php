<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

use Symfony\Component\VarExporter\LazyGhostTrait;

abstract class AbstractLazyDefinition implements DefinitionInterface
{
    use LazyGhostTrait;

    public function __construct(
        private readonly string $identifier,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
