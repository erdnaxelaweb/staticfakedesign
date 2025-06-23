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
    public object $fields;
    public string $type;

    public function __construct()
    {
        $this->fields = (object) [];
    }
}
