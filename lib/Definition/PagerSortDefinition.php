<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

class PagerSortDefinition extends AbstractLazyDefinition
{
    public function __construct(
        string                             $identifier,
        private readonly string            $type,
        private readonly DefinitionOptions $options
    ) {
        parent::__construct($identifier);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptions(): DefinitionOptions
    {
        return $this->options;
    }
}
