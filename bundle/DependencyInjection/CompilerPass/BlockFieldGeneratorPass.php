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

namespace ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass;

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\AttributeGeneratorRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BlockFieldGeneratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (! $container->has(AttributeGeneratorRegistry::class)) {
            return;
        }

        $registry = $container->getDefinition(AttributeGeneratorRegistry::class);
        $services = $container->findTaggedServiceIds('erdnaxelaweb.static_fake_design.generator.block_field');
        foreach ($services as $id => $attributes) {
            $type = $attributes[0]['type'] ?? null;
            if ($type) {
                $registry->addMethodCall('registerGenerator', [$type, new Reference($id)]);
            }
        }
    }
}
