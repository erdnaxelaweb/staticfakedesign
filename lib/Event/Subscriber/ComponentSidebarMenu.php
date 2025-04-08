<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Event\Subscriber;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentFinder;
use ErdnaxelaWeb\StaticFakeDesign\Event\ConfigureMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class ComponentSidebarMenu implements EventSubscriberInterface
{
    public function __construct(
        protected ComponentFinder $componentFinder,
        protected RouterInterface $router
    ) {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::SHOWROOM_MENU_SIDEBAR => ['buildMenu', 0],
        ];
    }

    public function buildMenu(ConfigureMenuEvent $event): void
    {
        $factory = $event->getFactory();
        $menu = $event->getMenu();

        $components = $this->componentFinder->findComponents();

        $menuItems = [];
        $root = $menu->addChild(/** @Desc('Components') */ 'sidebar.components.root');
        foreach ($components as $componentPath => $component) {
            $splittedPath = explode('/', $componentPath);
            $templateName = array_pop($splittedPath);
            $parent = $root;
            $path = [];
            foreach ($splittedPath as $dirName) {
                $path[] = $dirName;
                $dirPath = implode('/', $path);
                if (!isset($menuItems[$dirPath])) {
                    $menuItems[$dirPath] = $parent->addChild($dirPath, [
                        'label' => $dirName,
                        'extras' => [
                            'path' => $dirPath,
                            'icon' => 'folder',
                        ],
                    ]);
                }
                $parent = $menuItems[$dirPath];
            }
            $parent->addChild($templateName, [
                'uri' => $this->router->generate('showroom_component', [
                    'path' => $componentPath,
                ]),
                'label' => $component->getName(),
                'extras' => [
                    'path' => $componentPath,
                    'icon' => 'box',
                ],
            ]);
        }
        $this->reorder($root);
    }

    protected function reorder(ItemInterface $parent): void
    {
        $children = $parent->getChildren();
        $order = [];
        foreach ($children as $child) {
            if ($child->hasChildren()) {
                $this->reorder($child);
            }
            $abel = iconv('UTF-8', 'ASCII//TRANSLIT', $child->getLabel());
            $order[$abel] = $child;
        }
        ksort($order, SORT_LOCALE_STRING);
        $parent->reorderChildren(
            array_map(static function (ItemInterface $item): string {
                return $item->getName();
            }, $order)
        );
    }
}
