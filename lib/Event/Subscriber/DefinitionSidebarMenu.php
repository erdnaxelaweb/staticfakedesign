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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use ErdnaxelaWeb\StaticFakeDesign\Event\ConfigureMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class DefinitionSidebarMenu implements EventSubscriberInterface
{
    public function __construct(
        protected DefinitionManager $definitionManager,
        protected RouterInterface   $router
    ) {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::SHOWROOM_MENU_SIDEBAR => ['buildMenu', -10],
        ];
    }

    public function buildMenu(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $root = $menu->addChild('sidebar.definitions.root');

        // @todo
        //        $this->addDefinitions(ContentDefinition::class, 'content', $this->definitionManager, $root);
        //        $this->addDefinitions(TaxonomyEntryDefinition::class, 'taxonomy', $this->definitionManager, $root);
        //        $this->addDefinitions(BlockDefinition::class, 'block', $this->definitionManager, $root);
        //        $this->addDefinitions(PagerDefinition::class, 'pager', $this->definitionManager, $root);
    }

    protected function addDefinitions(
        string            $definitionType,
        DefinitionManager $definitionManager,
        ItemInterface     $menu
    ): void {
        $types = $definitionManager->getDefinitionsByType($definitionType);
        if (empty($types)) {
            return;
        }
        $root = $menu->addChild(sprintf('sidebar.definitions.%s', $definitionType), [
            'extras' => [
                'icon' => 'folder',
            ],
        ]);

        foreach ($types as $type) {
            $uri = $this->router->generate('showroom_definition', [
                'definitionType' => $definitionType,
                'type' => $type,
            ]);
            $root->addChild($type, [
                'uri' => $uri,
                'label' => $type,
                'extras' => [
                    'path' => $uri,
                    'icon' => 'card-text',
                ],
            ]);
        }
    }
}
