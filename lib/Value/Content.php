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

class Content extends AbstractContent implements ContentInterface
{
    /**
     * @param string[] $languageCodes
     */
    public function __construct(
        int                        $id,
        string                     $name,
        string                     $type,
        array                      $languageCodes,
        string                     $mainLanguageCode,
        bool                       $alwaysAvailable,
        bool                       $hidden,
        DateTime                   $creationDate,
        DateTime                   $modificationDate,
        ContentFieldsCollection    $fields,
        protected readonly string     $url,
        protected readonly Breadcrumb $breadcrumb,
        protected readonly ?Content   $parent
    ) {
        parent::__construct(
            $id,
            $name,
            $type,
            $languageCodes,
            $mainLanguageCode,
            $alwaysAvailable,
            $hidden,
            $creationDate,
            $modificationDate,
            $fields
        );
    }

    public function getUrl(): string
    {
        return $this->getPropertyValue('url');
    }

    public function getBreadcrumb(): Breadcrumb
    {
        return $this->getPropertyValue('breadcrumb');
    }

    public function getParent(): ?Content
    {
        return $this->getPropertyValue('parent');
    }
}
