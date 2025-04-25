<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Exception;

use Exception;

class VariationConfigurationNotFoundException extends Exception
{
    public function __construct(string $variationName)
    {
        parent::__construct("Config for variation '$variationName' not found");
    }
}
