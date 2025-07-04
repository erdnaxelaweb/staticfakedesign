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

class TaxonomyEntry extends AbstractContent
{
    /**
     * @param string[]                                                        $languageCodes
     */
    public function __construct(
        int                            $id,
        string                         $name,
        string                         $type,
        array                         $languageCodes,
        string                    $mainLanguageCode,
        bool                           $alwaysAvailable,
        bool                           $hidden,
        DateTime                       $creationDate,
        DateTime                       $modificationDate,
        ContentFieldsCollection        $fields,
        public readonly string         $identifier,
        public readonly int            $level = 0,
        public readonly ?TaxonomyEntry $parent = null,
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
}
