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

namespace ErdnaxelaWeb\StaticFakeDesign\Showroom\Menu;

use ErdnaxelaWeb\StaticFakeDesign\Event\ConfigureMenuEvent;
use Knp\Menu\ItemInterface;

class SidebarMenuBuilder extends AbstractMenuBuilder
{
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
