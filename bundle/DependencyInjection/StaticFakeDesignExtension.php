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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

class StaticFakeDesignExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array<mixed>                                                   $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
        $loader->load('showroom.yaml');
        $loader->load('fake_generators.yaml');
        $loader->load('fake_form_generators.yml');
        $loader->load('fake_content_field_generator.yaml');
        $loader->load('fake_block_attribute_generator.yaml');
        $loader->load('definitions.yaml');

        $config = $this->processConfiguration($configuration, $configs);

        if (!empty($config['block_definition'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.block_definition', $config['block_definition']);
        }
        if (!empty($config['block_layout_definition'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.block_layout_definition', $config['block_layout_definition']);
        }
        if (!empty($config['content_definition'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.content_definition', $config['content_definition']);
        }
        if (!empty($config['taxonomy_entry_definition'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.pager_definition', $config['taxonomy_entry_definition']);
        }
        if (!empty($config['pager_definition'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.pager_definition', $config['pager_definition']);
        }
        if (!empty($config['document_definition'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.document_definition', $config['document_definition']);
        }
        if (!empty($config['image']['variations'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.image.variations', $config['image']['variations']);
        }
        if (!empty($config['image']['breakpoints'])) {
            $container->setParameter('erdnaxelaweb.static_fake_design.image.breakpoints', $config['image']['breakpoints']);
        }
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('twig')) {
            return;
        }

        $config = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/prepend/twig.yaml'));
        $config['paths'] = [__DIR__ . '/../templates'];

        $container->prependExtensionConfig('twig', $config);
    }
}
