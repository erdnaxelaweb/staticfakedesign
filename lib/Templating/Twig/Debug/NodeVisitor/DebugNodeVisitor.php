<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Debug\NodeVisitor;

use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Debug\Node\EnterDebugNode;
use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Debug\Node\LeaveDebugNode;
use Twig\Environment;
use Twig\Node\BlockNode;
use Twig\Node\BodyNode;
use Twig\Node\MacroNode;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;

class DebugNodeVisitor implements NodeVisitorInterface
{
    public function __construct(
        protected string $kernelProjectDir
    ) {
    }

    public function enterNode(Node $node, Environment $env): Node
    {
        return $node;
    }

    public function leaveNode(Node $node, Environment $env): ?Node
    {
        if ( ! $env->isDebug() || !str_contains( $node->getTemplateName(), '.html.twig' ) ) {
            return $node;
        }

        if ($node instanceof ModuleNode) {
            $node->setNode(
                'display_start',
                new Node(
                    [
                        new EnterDebugNode($this->getTemplatePath($node->getSourceContext()->getPath())),
                        $node->getNode('display_start'),
                    ]
                )
            );
            $node->setNode(
                'display_end',
                new Node(
                    [
                        new LeaveDebugNode($this->getTemplatePath($node->getSourceContext()->getPath())),
                        $node->getNode('display_end'),
                    ]
                )
            );
        } elseif ($node instanceof BlockNode) {
            $node->setNode(
                'body',
                new BodyNode([
                    new EnterDebugNode($this->getTemplatePath($node->getSourceContext()->getPath())),
                    $node->getNode('body'),
                    new LeaveDebugNode($this->getTemplatePath($node->getSourceContext()->getPath())),
                ])
            );
        } elseif ($node instanceof MacroNode) {
            $node->setNode(
                'body',
                new BodyNode([
                    new EnterDebugNode($this->getTemplatePath($node->getSourceContext()->getPath())),
                    $node->getNode('body'),
                    new LeaveDebugNode($this->getTemplatePath($node->getSourceContext()->getPath())),
                ])
            );
        }

        return $node;
    }

    protected function getTemplatePath(string $path)
    {
        return str_replace($this->kernelProjectDir . "/", '', $path);
    }

    public function getPriority()
    {
        return 0;
    }
}
