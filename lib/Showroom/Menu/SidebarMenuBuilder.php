<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Showroom\Menu;

use ErdnaxelaWeb\StaticFakeDesign\Event\ConfigureMenuEvent;
use Knp\Menu\ItemInterface;

class SidebarMenuBuilder extends AbstractMenuBuilder
{
    /**
     * @param array<mixed> $options
     */
    public function buildMenu(array $options = []): ItemInterface
    {
        $menu = $this->createMenuItem('sidebar.root');

        $this->dispatchMenuEvent(
            ConfigureMenuEvent::SHOWROOM_MENU_SIDEBAR,
            new ConfigureMenuEvent($this->factory, $menu, $options)
        );

        return $menu;
    }
}
