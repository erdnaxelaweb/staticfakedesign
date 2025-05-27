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

class ContentRelationDefinition
{
    /**
     * @param string[]   $destinationContentType
     */
    public function __construct(
        protected string $sourceContentTypes,
        protected array $destinationContentType,
        protected int              $type,
        protected string $sourceFieldIdentifier
    ) {
    }

    public function getSourceContentTypes(): string
    {
        return $this->sourceContentTypes;
    }

    /**
     * @return string[]
     */
    public function getDestinationContentType(): array
    {
        return $this->destinationContentType;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getSourceFieldIdentifier(): string
    {
        return $this->sourceFieldIdentifier;
    }
}
