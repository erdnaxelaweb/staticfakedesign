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

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Node;

use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Extension;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

class ComponentNode extends Node
{
    public function __construct(?AbstractExpression $parameters, array $nodes = [], array $attributes = [], int $lineno = 0, string $tag = null)
    {
        if (null !== $parameters) {
            $nodes['parameters'] = $parameters;
        }
        parent::__construct($nodes, $attributes, $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        if ($this->hasNode('parameters')) {
            $extensionName = Extension::class;
            $varName = sprintf('__internal_%s', hash(\PHP_VERSION_ID < 80100 ? 'sha256' : 'xxh128', $extensionName));

            $compiler
                ->write(sprintf('$%s = $this->extensions[', $varName))
                ->repr($extensionName)
                ->raw("];\n")
                ->write(sprintf('$this->component = $%s->buildComponent(', $varName))
                ->subcompile($this->getNode('parameters'))
                ->raw(', $this);');
        }
    }
}
