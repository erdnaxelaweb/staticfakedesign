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

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Controller;

use ErdnaxelaWeb\StaticFakeDesign\Showroom\ComponentFinder;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\ComponentViewParametersResolverFactory;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\Menu\SidebarMenuFactory;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\ShowroomHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShowroomController extends AbstractController
{
    public function __construct(
        protected SidebarMenuFactory $sidebarMenuFactory,
        protected ComponentFinder $componentFinder,
        protected ComponentViewParametersResolverFactory $componentViewParametersResolverFactory,
        protected ShowroomHelper $showroomHelper,
        protected string $previewLayout
    ) {
    }

    public function view(string $path = null): Response
    {
        $component = $this->componentFinder->getComponentFromPath($path);
        return $this->render('@StaticFakeDesign/showroom/index.html.twig', [
            'path' => $path,
            'component' => $component,
        ]);
    }

    public function sidebar(): Response
    {
        $menu = $this->sidebarMenuFactory->buildMenu();
        return $this->render('@StaticFakeDesign/showroom/include/sidebar.html.twig', [
            'menu' => $menu,
        ],);
    }

    public function preview(string $path, array $parameters = []): Response
    {
        $component = $this->componentFinder->getComponentFromPath($path);

        $this->showroomHelper->setPreviewActive(true);

        $templateParameters = [
            'page_title' => $component->name,
        ];

        if ($component->template->getParent([])) {
            $templatePath = $component->template->getTemplateName();
        } else {
            $templatePath = '@StaticFakeDesign/showroom/preview.html.twig';
            $templateParameters['templatePath'] = $component->template->getTemplateName();
            $templateParameters['templateParameters'] = [];
        }

        return $this->render($templatePath, $templateParameters);
    }
}
