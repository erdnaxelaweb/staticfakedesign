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

namespace ErdnaxelaWeb\StaticFakeDesign\Event\Subscriber;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\AbstractConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\ContentConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\PagerConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\TaxonomyEntryConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Event\ConfigureMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class DefinitionSidebarMenu implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::SHOWROOM_MENU_SIDEBAR => ['buildMenu', -10],
        ];
    }

    public function __construct(
        protected ContentConfigurationManager $contentConfigurationManager,
        protected TaxonomyEntryConfigurationManager $taxonomyEntryConfigurationManager,
        protected BlockConfigurationManager $blockConfigurationManager,
        protected PagerConfigurationManager $pagerConfigurationManager,
        protected RouterInterface $router
    ) {
    }

    public function buildMenu(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $root = $menu->addChild('definitions.root', [
            'extras' => [
                'translation_domain' => 'menu',
            ],
        ]);

        $this->addDefinitions('content', $this->contentConfigurationManager, $root);
        $this->addDefinitions('taxonomy', $this->taxonomyEntryConfigurationManager, $root);
        $this->addDefinitions('block', $this->blockConfigurationManager, $root);
        $this->addDefinitions('pager', $this->pagerConfigurationManager, $root);
    }

    protected function addDefinitions(
        string $definitionType,
        AbstractConfigurationManager $configurationManager,
        ItemInterface $menu
    ): void {
        $types = $configurationManager->getConfigurationsType();
        if (empty($types)) {
            return;
        }
        $root = $menu->addChild(sprintf('definitions.%s', $definitionType), [
            'extras' => [
                'translation_domain' => 'menu',
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
