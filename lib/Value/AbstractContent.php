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
use Symfony\Component\VarExporter\LazyGhostTrait;

class AbstractContent
{
    use LazyGhostTrait;

    /**
     * @param string[]                                                        $languageCodes
     */
    public function __construct(
        public readonly int                     $id,
        public readonly string                  $name,
        public readonly string                  $type,
        public readonly array                  $languageCodes,
        public readonly string                    $mainLanguageCode,
        public readonly bool                    $alwaysAvailable,
        public readonly DateTime                $creationDate,
        public readonly DateTime                $modificationDate,
        public readonly ContentFieldsCollection $fields
    ) {
    }
}
