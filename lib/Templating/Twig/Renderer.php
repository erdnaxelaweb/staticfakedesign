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

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use ErdnaxelaWeb\StaticFakeDesign\Showroom\ShowroomHelper;
use Knp\Menu\ItemInterface;
use Twig\Environment;
use Twig\TwigFunction;

class Renderer
{
    public function __construct(
        protected ShowroomHelper $showroomHelper,
    ) {
    }

    public function getTwigFunctions()
    {
        $functions = [
            'display_component' => [$this, 'displayComponent'],
            'display_menu_item' => [$this, 'displayMenuItem'],
            'display_active_filter' => [$this, 'displayActiveFilter'],
        ];

        $twigFunctions = [];
        foreach ($functions as $functionName => $functionCallback) {
            $twigFunctions[] = new TwigFunction($functionName, $functionCallback, [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]);
        }

        return $twigFunctions;
    }

    public function displayActiveFilter(Environment $environment, ItemInterface $item, array $parameters = []): string
    {
        return $this->render($environment, 'display_active_filter', [
            'item' => $item,
            ...$parameters,
        ]);
    }

    public function displayMenuItem(Environment $environment, ItemInterface $item, array $parameters = []): string
    {
        return $this->render($environment, 'display_menu_item', [
            'item' => $item,
            ...$parameters,
        ]);
    }

    public function displayComponent(
        Environment $environment,
        string      $template,
        array       $parameters = [],
        ?string     $controllerAction = null
    ): string {
        return $this->render($environment, 'display_component', [
            'template' => $template,
            'parameters' => $parameters,
            'controllerAction' => $controllerAction,
        ]);
    }

    protected function render(Environment $environment, string $blockName, array $parameters = []): string
    {
        $renderTemplate = $environment->loadTemplate(
            $environment->getTemplateClass($this->showroomHelper->getRenderTemplate()),
            $this->showroomHelper->getRenderTemplate()
        );
        $context = $environment->mergeGlobals($parameters);
        return $renderTemplate->renderBlock($blockName, $context);
    }
}
