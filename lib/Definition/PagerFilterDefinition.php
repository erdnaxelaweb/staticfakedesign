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

class PagerFilterDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'pager_filter';

    public function __construct(
        string                             $identifier,
        protected readonly string            $type,
        protected readonly DefinitionOptions $options
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
