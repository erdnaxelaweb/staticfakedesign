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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

class StaticFakeDesignExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
        $loader->load('showroom.yaml');
        $loader->load('fake_generators.yaml');
        $loader->load('fake_form_generators.yml');
        $loader->load('fake_content_field_generator.yaml');
        $loader->load('fake_block_attribute_generator.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (! $container->hasExtension('twig')) {
            return;
        }

        $config = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/prepend/twig.yaml'));
        $config['paths'] = [__DIR__ . '/../templates'];

        $container->prependExtensionConfig('twig', $config);
    }
}
