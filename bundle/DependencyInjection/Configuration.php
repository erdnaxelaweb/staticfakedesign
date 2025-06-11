<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('static_fake_design');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();
        self::configureRootNode($rootNode->children());

        return $treeBuilder;
    }

    public static function configureRootNode(NodeBuilder $rootNode): void
    {
        /* @phpstan-ignore method.notFound */
        $rootNode
            ->arrayNode('pager_definition')
                ->prototype('variable')->end()
            ->end()
            ->arrayNode('block_definition')
                ->prototype('variable')->end()
            ->end()
            ->arrayNode('block_layout_definition')
                ->prototype('variable')->end()
            ->end()
            ->arrayNode('content_definition')
                ->prototype('variable')->end()
            ->end()
            ->arrayNode('document_definition')
                ->prototype('variable')->end()
            ->end()
            ->arrayNode('taxonomy_entry_definition')
                ->prototype('variable')->end()
            ->end()
            ->arrayNode('image')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('breakpoints')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('suffix')->isRequired()->end()
                                ->scalarNode('media')->isRequired()->end()
                                ->scalarNode('previewSize')->defaultValue('100%')->end()
                                ->booleanNode('use_webp')->defaultTrue()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('variations')
                        ->prototype('variable')->end()
                    ->end()
                ->end()
            ->end();
    }
}
