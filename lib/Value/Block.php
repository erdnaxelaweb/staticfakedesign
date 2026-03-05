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

use DateTime;
use ErdnaxelaWeb\StaticFakeDesign\LazyLoading\LazyObjectTrait;

class Block
{
    use LazyObjectTrait;

    public function __construct(
        protected readonly int                       $id,
        protected readonly string                    $name,
        protected readonly string                    $type,
        protected readonly string                    $view,
        protected readonly ?string                   $class,
        protected readonly ?string                   $style,
        protected readonly ?DateTime                 $since,
        protected readonly ?DateTime                 $till,
        protected readonly bool                      $isVisible,
        protected readonly BlockAttributesCollection $attributes,
    ) {
    }

    public function getId(): int
    {
        return $this->getPropertyValue('id');
    }

    public function getName(): string
    {
        return $this->getPropertyValue('name');
    }

    public function getType(): string
    {
        return $this->getPropertyValue('type');
    }

    public function getView(): string
    {
        return $this->getPropertyValue('view');
    }

    public function getClass(): ?string
    {
        return $this->getPropertyValue('class');
    }

    public function getStyle(): ?string
    {
        return $this->getPropertyValue('style');
    }

    public function getSince(): ?DateTime
    {
        return $this->getPropertyValue('since');
    }

    public function getTill(): ?DateTime
    {
        return $this->getPropertyValue('till');
    }

    public function isVisible(): bool
    {
        return $this->getPropertyValue('isVisible');
    }

    public function getAttributes(): BlockAttributesCollection
    {
        return $this->getPropertyValue('attributes');
    }
}
