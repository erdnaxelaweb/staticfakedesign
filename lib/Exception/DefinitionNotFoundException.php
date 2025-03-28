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

namespace ErdnaxelaWeb\StaticFakeDesign\Exception;

use Exception;

class DefinitionNotFoundException extends Exception
{
    public function __construct(string $type, string $identifier)
    {
        parent::__construct("Definition $identifier (type: $type) not found");
    }
}
