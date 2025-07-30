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
    public string $id;
    public int $contentId;
    public string $languageCode;
    public bool $isMainTranslation;
    public bool $alwaysAvailable;
    public bool $hidden;
    public object $fields;
    public string $type;

    public function __construct()
    {
        $this->fields = (object) [];
    }

    public function cacheTag(): string
    {
        $shortType = $this->getShortType();
        return sprintf('d-%s-%s', $shortType, $this->contentId);
    }

    protected function getShortType(): string
    {
        return implode(
            '',
            array_map(
                function (string $word) {
                    return substr($word, 0, 1);
                },
                explode(
                    '_',
                    str_replace('-', '_', $this->type)
                )
            )
        );
    }
}
