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

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\ShowroomHelper;
use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Debug\NodeVisitor\DebugNodeVisitor;
use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\NodeVisitor\ComponentNodeVisitor;
use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\TokenParser\ComponentTokenParser;
use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use Twig\Extension\AbstractExtension;
use Twig\Template;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function __construct(
        protected ChainGenerator   $generator,
        protected FakerGenerator   $fakerGenerator,
        protected ComponentBuilder $componentBuilder,
        protected Renderer         $renderer,
        protected ShowroomHelper                  $showroomHelper,
        protected string           $kernelProjectDir
    ) {
    }

    public function getFunctions(): array
    {
        return array_merge(
            [
                new TwigFunction('generateFake', [$this->generator, 'generateFake'], [
                    'is_safe' => ['html'],
                ]),
                new TwigFunction('generateFakeArray', [$this->generator, 'generateFakeArray'], [
                    'is_safe' => ['html'],
                ]),
            ],
            $this->renderer->getTwigFunctions()
        );
    }

    public function buildComponent(array $parameters, Template $template): Component
    {
        return $this->componentBuilder->fromArray($parameters, $template);
    }

    public function setContext(array &$context, ?Component $component): void
    {
        if (! $component) {
            return;
        }
        foreach ($component->getParameters() as $parameter) {
            if (isset($context[$parameter->getName()])) {
                continue;
            }
            if (! $parameter->isRequired() && $parameter->hasDefaultValue()) {
                $context[$parameter->getName()] = $parameter->getDefaultValue();
            }
        }
        foreach ($component->getProperties() as $property) {
            if (isset($context[$property->getName()])) {
                continue;
            }
            if ($property->hasDefaultValue()) {
                $context[$property->getName()] = $property->getDefaultValue();
            } elseif ($this->showroomHelper->isPreviewActive()) {
                $context[$property->getName()] = $this->generator->generateFromTypeExpression($property->getType());
            }
        }
    }

    public function getNodeVisitors(): array
    {
        return [new DebugNodeVisitor($this->kernelProjectDir), new ComponentNodeVisitor()];
    }

    public function getTokenParsers(): array
    {
        return [new ComponentTokenParser()];
    }
}
