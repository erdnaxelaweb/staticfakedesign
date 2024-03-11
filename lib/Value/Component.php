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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Twig\Template;

class Component
{
    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameter[] $parameters
     */
    public function __construct(
        public Template $template,
        public string $name,
        public string $description = '',
        public array $parameters = []
    ) {
    }
}
