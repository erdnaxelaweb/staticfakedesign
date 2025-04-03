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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class ComponentSidebarMenu implements EventSubscriberInterface
{
    public function __construct(
        protected ComponentFinder $storiesFinder,
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

        $stories = $this->storiesFinder->findComponents();

        $menuItems = [];
        $root = $menu->addChild(/** @Desc('Components') */ 'sidebar.components.root');
        foreach ($stories as $storyPath => $story) {
            $splittedPath = explode('/', $storyPath);
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
                    'path' => $storyPath,
                ]),
                'label' => $story->getName(),
                'extras' => [
                    'path' => $storyPath,
                    'icon' => 'box',
                ],
            ]);
        }
    }
}
