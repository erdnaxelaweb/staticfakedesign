<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
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

    public function compile(Compiler $compiler): void
    {
        $compiler->write(sprintf('echo "<!-- END: %s -->";', $this->getAttribute('template_path')))
            ->raw("\n");
    }
}
