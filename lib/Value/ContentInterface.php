<?php
/*
 * ibexadesignbundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/ibexadesignintegration/blob/main/LICENSE
 */

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

/**
 * @property-read int                     $id
 * @property-read string                  $name
 * @property-read string                  $type
 * @property-read string[]                $languageCodes
 * @property-read string                  $mainLanguageCode
 * @property-read bool                    $alwaysAvailable
 * @property-read DateTime                $creationDate
 * @property-read DateTime                $modificationDate
 * @property-read ContentFieldsCollection $fields
 * @property-read string                  $url
 * @property-read Breadcrumb              $breadcrumb
 */
interface ContentInterface
{
}
