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

abstract class AbstractContent
{
    use LazyObjectTrait;

    /**
     * @param string[]                                                        $languageCodes
     */
    public function __construct(
        protected readonly int                     $id,
        protected readonly string                  $name,
        protected readonly string                  $type,
        protected readonly array                   $languageCodes,
        protected readonly string                  $mainLanguageCode,
        protected readonly bool                    $alwaysAvailable,
        protected readonly bool                    $hidden,
        protected readonly DateTime                $creationDate,
        protected readonly DateTime                $modificationDate,
        protected readonly ContentFieldsCollection $fields
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

    /**
     * @return string[]
     */
    public function getLanguageCodes(): array
    {
        return $this->getPropertyValue('languageCodes');
    }

    public function getMainLanguageCode(): string
    {
        return $this->getPropertyValue('mainLanguageCode');
    }

    public function isAlwaysAvailable(): bool
    {
        return $this->getPropertyValue('alwaysAvailable');
    }

    public function isHidden(): bool
    {
        return $this->getPropertyValue('hidden');
    }

    public function getCreationDate(): DateTime
    {
        return $this->getPropertyValue('creationDate');
    }

    public function getModificationDate(): DateTime
    {
        return $this->getPropertyValue('modificationDate');
    }

    public function getFields(): ContentFieldsCollection
    {
        return $this->getPropertyValue('fields');
    }
}
