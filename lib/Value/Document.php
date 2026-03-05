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

class Document
{
    public readonly string $id;
    public readonly int $contentId;
    public readonly string $languageCode;
    public readonly bool $isMainTranslation;
    public readonly bool $alwaysAvailable;
    public readonly bool $hidden;
    public readonly object $fields;
    public readonly string $type;

    public function __construct(
        string $id,
        int    $contentId,
        string $languageCode,
        bool   $isMainTranslation,
        bool   $alwaysAvailable,
        bool   $hidden,
        object $fields,
        string $type
    ) {
        $this->id = $id;
        $this->contentId = $contentId;
        $this->languageCode = $languageCode;
        $this->isMainTranslation = $isMainTranslation;
        $this->alwaysAvailable = $alwaysAvailable;
        $this->hidden = $hidden;
        $this->fields = $fields;
        $this->type = $type;
    }


    public function cacheTag(): string
    {
        $shortType = $this->getShortType();
        return sprintf('d-%s-%s', $shortType, $this->contentId);
    }

    public function getShortType(): string
    {
        return implode(
            '',
            array_map(
                fn (string $word) => substr($word, 0, 1),
                explode(
                    '_',
                    str_replace('-', '_', $this->type)
                )
            )
        );
    }
}
