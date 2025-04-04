<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Node;

use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Extension;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

class ComponentReferenceNode extends Node
{
    /**
     * @param array<string, string> $nodes
     * @param array<string, mixed>  $attributes
     */
    public function __construct(
        ?AbstractExpression $parameters,
        array               $nodes = [],
        array               $attributes = [],
        int                 $lineno = 0,
        string              $tag = null
    ) {
        if (null !== $parameters) {
            $nodes['parameters'] = $parameters;
        }
        parent::__construct($nodes, $attributes, $lineno, $tag);
    }

    public function compile(Compiler $compiler): void
    {
        $extensionName = Extension::class;
        $varName = sprintf('__internal_%s', hash('xxh128', $extensionName));

        $compiler
            ->write(sprintf('$%s = $this->extensions[', $varName))
            ->repr($extensionName)
            ->raw("];\n")
            ->write(sprintf('$%s->setContext($context, $this->component ?? null);', $varName));
    }
}
