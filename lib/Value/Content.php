<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
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
        public readonly string $url = "",
        public readonly array  $breadcrumb = []
    ) {
        parent::__construct($name, $type, $creationDate, $modificationDate, $fields);
    }
}
