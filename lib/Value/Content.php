<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use DateTime;

class Content extends AbstractContent
{
    public function __construct(
        string $name,
        string $type,
        DateTime $creationDate,
        DateTime $modificationDate,
        ContentFieldsCollection  $fields,
        public readonly string $url,
        public readonly Breadcrumb  $breadcrumb,
    ) {
        parent::__construct($name, $type, $creationDate, $modificationDate, $fields);
    }
}
