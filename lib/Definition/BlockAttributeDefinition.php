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

class BlockAttributeDefinition extends AbstractLazyDefinition
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
