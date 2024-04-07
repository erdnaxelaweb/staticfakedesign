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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use Knp\Menu\ItemInterface;
use Twig\Environment;
use Twig\TwigFunction;

class Renderer
{
    public function __construct(
        protected string $renderTemplate,
        protected BlockConfigurationManager $blockConfigurationManager
    ) {
    }

    protected function getDisplayFunctions(): array
    {
        return [
            'display_component' => [$this, 'displayComponent'],
            'display_menu_item' => [$this, 'displayMenuItem'],
            'display_active_filter' => [$this, 'displayActiveFilter'],
            'display_content' => [$this, 'displayContent'],
            'display_block' => [$this, 'displayBlock'],
        ];
    }

    public function getTwigFunctions(): array
    {
        $functions = $this->getDisplayFunctions();

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

    public function displayContent(
        Environment $environment,
        string      $template,
        $content,
        array       $parameters = [],
        bool $isEsi = false,
        ?string     $viewType = null
    ): string {
        if (! $viewType && preg_match('#content/([^/]+)/#', $template, $matches)) {
            $viewType = $matches[1];
        }

        return $this->render($environment, 'display_content', [
            'template' => $template,
            'content' => $content,
            'parameters' => $parameters,
            'viewType' => $viewType,
            'isEsi' => $isEsi,
        ]);
    }

    public function displayComponent(
        Environment $environment,
        string      $template,
        array       $parameters = [],
        ?string     $controllerAction = null,
        bool $isEsi = false
    ): string {
        return $this->render($environment, 'display_component', [
            'template' => $template,
            'parameters' => $parameters,
            'controllerAction' => $controllerAction,
        ]);
    }

    public function displayBlock(Environment $environment, $block, bool $isEsi = true): string
    {
        $template = null;
        if ($block instanceof Block) {
            $blockConfiguration = $this->blockConfigurationManager->getConfiguration($block->type);
            $template = $blockConfiguration['views'][$block->view];
        }
        return $this->render($environment, 'display_block', [
            'template' => $template,
            'block' => $block,
            'isEsi' => $isEsi,
        ]);
    }

    protected function render(Environment $environment, string $blockName, array $parameters = []): string
    {
        $renderTemplate = $environment->loadTemplate(
            $environment->getTemplateClass($this->renderTemplate),
            $this->renderTemplate
        );
        $context = $environment->mergeGlobals($parameters);
        return $renderTemplate->renderBlock($blockName, $context);
    }
}
