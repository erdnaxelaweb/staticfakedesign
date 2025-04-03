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

class Content extends AbstractContent
{
    public function __construct(
        int                        $id,
        string                     $name,
        string                     $type,
        DateTime                   $creationDate,
        DateTime                   $modificationDate,
        ContentFieldsCollection    $fields,
        public readonly string     $url,
        public readonly Breadcrumb $breadcrumb,
    ) {
        parent::__construct($id, $name, $type, $creationDate, $modificationDate, $fields);
    }
}
