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

class VariationConfigurationNotFoundException extends Exception
{
    public function __construct(string $variationName)
    {
        parent::__construct("Config for variation $variationName not found");
    }
}
