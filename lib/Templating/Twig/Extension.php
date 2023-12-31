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

use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Debug\NodeVisitor\DebugNodeVisitor;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function __construct(
        protected ChainGenerator $generator,
        protected string $kernelProjectDir
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('generateFake', [$this->generator, 'generateFake'], [
                'is_safe' => ['html'],
            ]),
            new TwigFunction('generateFakeArray', [$this->generator, 'generateFakeArray'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function getNodeVisitors()
    {
        return [new DebugNodeVisitor($this->kernelProjectDir)];
    }
}
