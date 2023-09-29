<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function __construct(
        protected ChainGenerator $generator
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
}
