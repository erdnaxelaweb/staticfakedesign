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

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Controller\Showroom;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentFinder;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\ShowroomHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Template;

class ComponentController extends AbstractController
{
    public function __construct(
        protected ComponentFinder                        $componentFinder,
        protected ShowroomHelper                         $showroomHelper,
        protected Environment $twig
    ) {
    }

    public function view(string $path = null): Response
    {
        $component = $path ? $this->componentFinder->getComponentFromPath($path) : null;
        return $this->render('@StaticFakeDesign/showroom/component.html.twig', [
            'path' => $path,
            'component' => $component,
        ]);
    }

    public function preview(string $path, array $parameters = []): Response
    {
        $component = $this->componentFinder->getComponentFromPath($path);
        $isFullTemplate = $this->isFullTemplate($component->getTemplate());
        $this->showroomHelper->setPreviewActive(true);

        $templateParameters = [
            'page_title' => $component->getName(),
        ];

        if ($isFullTemplate) {
            $templatePath = $component->getTemplate()
                ->getTemplateName();
        } else {
            $templatePath = '@StaticFakeDesign/showroom/component-preview.html.twig';
            $templateParameters['templatePath'] = $component->getTemplate()->getTemplateName();
            $templateParameters['templateParameters'] = [];
        }

        return $this->render($templatePath, $templateParameters);
    }

    protected function isFullTemplate(Template $template): bool
    {
        $parent = $template->getParent($this->twig->mergeGlobals([]));
        if ($parent) {
            return $this->isFullTemplate($parent);
        }
        return str_contains($template->getSourceContext()->getCode(), '</html>');
    }
}
