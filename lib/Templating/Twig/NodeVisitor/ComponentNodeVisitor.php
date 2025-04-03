<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\NodeVisitor;

use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Node\ComponentNode;
use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Node\ComponentReferenceNode;
use Twig\Environment;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;

class ComponentNodeVisitor implements NodeVisitorInterface
{
    private bool $inAModule = false;

    private ?ArrayExpression $storyParameters;

    public function enterNode(Node $node, Environment $env): Node
    {
        if ($node instanceof ModuleNode) {
            $this->inAModule = true;
            $this->storyParameters = null;
            return $node;
        } elseif ($this->inAModule) {
            if ($node instanceof ComponentReferenceNode) {
                /** @phpstan-ignore-next-line */
                $this->storyParameters = $node->getNode('parameters');
            }
        }

        return $node;
    }

    public function leaveNode(Node $node, Environment $env): ?Node
    {
        if ($node instanceof ModuleNode) {
            $this->inAModule = false;

            $node->setNode(
                'constructor_end',
                new Node([new ComponentNode($this->storyParameters), $node->getNode('constructor_end')])
            );
        }
        return $node;
    }

    public function getPriority(): int
    {
        return 0;
    }
}
