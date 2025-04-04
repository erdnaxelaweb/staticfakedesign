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

use Twig\Template;

class Component
{
    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter[] $parameters
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter[] $properties
     */
    public function __construct(
        protected readonly Template $template,
        protected readonly string   $name,
        protected readonly string   $type = 'default',
        protected readonly string   $description = '',
        protected readonly string   $specifications = '',
        protected readonly array    $properties = [],
        protected readonly array    $parameters = []
    ) {
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return \ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTemplateName(): string
    {
        return $this->getTemplate()
            ->getTemplateName();
    }
}
