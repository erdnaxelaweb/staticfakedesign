<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Debug\Node;

use Twig\Compiler;
use Twig\Node\Node;

class LeaveDebugNode extends Node
{
    public function __construct(string $templatePath)
    {
        parent::__construct([], [
            'template_path' => $templatePath,
        ]);
    }

    public function compile(Compiler $compiler)
    {
        $compiler->write(sprintf('echo "<!-- END: %s -->";', $this->getAttribute('template_path')))
            ->raw("\n");
    }
}
