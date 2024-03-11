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

use ErdnaxelaWeb\StaticFakeDesign\Showroom\ComponentFinder;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class SidebarMenuFactory
{
    public function __construct(
        protected FactoryInterface $factory,
        protected ComponentFinder  $storiesFinder,
        protected RouterInterface  $router
    ) {
    }

    public function buildMenu(): \Knp\Menu\ItemInterface
    {
        $stories = $this->storiesFinder->findComponents();

        $menuItems = [];
        $root = $this->factory->createItem('sidebar.root', [
            'extras' => [
                'translation_domain' => 'menu',
            ],
        ]);
        foreach ($stories as $storyPath => $story) {
            $splittedPath = explode('/', $storyPath);
            $templateName = array_pop($splittedPath);
            $parent = $root;
            $path = [];
            foreach ($splittedPath as $dirName) {
                $path[] = $dirName;
                $dirPath = implode('/', $path);
                if (! isset($menuItems[$dirPath])) {
                    $menuItem = $this->factory->createItem($dirPath, [
                        'label' => $dirName,
                        'extras' => [
                            'path' => $dirPath,
                        ],
                    ]);
                    $parent->addChild($menuItem);
                    $menuItems[$dirPath] = $menuItem;
                }
                $parent = $menuItems[$dirPath];
            }
            $menuItem = $this->factory->createItem($templateName, [
                'uri' => $this->router->generate('showroom', [
                    'path' => $storyPath,
                ]),
                'label' => $story->name,
                'extras' => [
                    'path' => $storyPath,
                ],
            ]);
            $parent->addChild($menuItem);
        }

        return $root;
    }
}
