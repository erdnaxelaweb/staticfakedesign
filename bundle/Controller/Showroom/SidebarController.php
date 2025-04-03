<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Controller\Showroom;

use ErdnaxelaWeb\StaticFakeDesign\Showroom\Menu\SidebarMenuBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SidebarController extends AbstractController
{
    public function __construct(
        protected SidebarMenuBuilder                     $sidebarMenuBuilder,
    ) {
    }

    public function sidebar(): Response
    {
        $menu = $this->sidebarMenuBuilder->buildMenu();
        return $this->render('@StaticFakeDesign/showroom/include/sidebar.html.twig', [
            'menu' => $menu,
        ]);
    }
}
