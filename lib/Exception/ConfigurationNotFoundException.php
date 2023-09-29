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

namespace ErdnaxelaWeb\StaticFakeDesign\Exception;

use Exception;

class ConfigurationNotFoundException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct("Config $type not found");
    }
}
