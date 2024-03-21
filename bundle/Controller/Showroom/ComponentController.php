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

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentContextResolverFactory;
use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentFinder;
use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentParametersFormFactory;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\ShowroomHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Template;

class ComponentController extends AbstractController
{
    public function __construct(
        protected ComponentFinder                 $componentFinder,
        protected ShowroomHelper                  $showroomHelper,
        protected ComponentContextResolverFactory $componentContextResolverFactory,
        protected ComponentParametersFormFactory $componentParametersFormFactory,
        protected Environment                     $twig,
        protected RouterInterface $router
    ) {
    }

    public function viewHome(): Response
    {
        return $this->render('@StaticFakeDesign/showroom/component-home.html.twig', []);
    }

    public function view(string $path = null): Response
    {
        $component = $path ? $this->componentFinder->getComponentFromPath($path) : null;
        $parametersForm = ($this->componentParametersFormFactory)($component);
        $previewUrl = $this->router->generate('showroom_component_preview', [
            'path' => $path,
        ]);
        return $this->render('@StaticFakeDesign/showroom/component.html.twig', [
            'path' => $path,
            'previewUrl' => $previewUrl,
            'component' => $component,
            'templateName' => $component->getTemplate()
                ->getTemplateName(),
            'parametersForm' => $parametersForm->createView(),
        ]);
    }

    public function preview(string $path, Request $request): Response
    {
        $component = $this->componentFinder->getComponentFromPath($path);
        $isFullTemplate = $this->isFullTemplate($component->getTemplate());
        $this->showroomHelper->setPreviewActive(true);

        $templateParameters = [
            'page_title' => $component->getName(),
        ];

        $parametersForm = ($this->componentParametersFormFactory)($component);
        $parametersForm->handleRequest($request);

        $context = $parametersForm->getData();
        if ($isFullTemplate) {
            $templatePath = $component->getTemplate()
                ->getTemplateName();
            $templateParameters = array_merge($templateParameters, $context);
        } else {
            $templatePath = '@StaticFakeDesign/showroom/component-preview.html.twig';
            $templateParameters['templatePath'] = $component->getTemplate()->getTemplateName();
            $templateParameters['templateParameters'] = $context;
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
