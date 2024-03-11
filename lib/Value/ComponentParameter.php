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

class ComponentParameter
{
    public function __construct(
        public string $name,
        public array $options = [],
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->options['type'];
    }

    public function getLabel()
    {
        return $this->options['label'];
    }

    public function getRequired()
    {
        return $this->options['required'];
    }
}
