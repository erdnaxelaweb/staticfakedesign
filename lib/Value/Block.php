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

class Block extends AbstractContent
{
    public function __construct(
        string                  $name,
        string                  $type,
        public readonly string  $view,
        ContentFieldsCollection $fields
    ) {
        parent::__construct($name, $type, $fields);
    }
}
