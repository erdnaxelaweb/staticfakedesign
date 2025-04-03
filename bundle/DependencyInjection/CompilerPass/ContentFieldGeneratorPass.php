<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ContentFieldGeneratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(FieldGeneratorRegistry::class)) {
            return;
        }

        $registry = $container->getDefinition(FieldGeneratorRegistry::class);
        $services = $container->findTaggedServiceIds('erdnaxelaweb.static_fake_design.generator.content_field');
        foreach ($services as $id => $attributes) {
            $type = $attributes[0]['type'] ?? null;
            if ($type) {
                $registry->addMethodCall('registerGenerator', [$type, new Reference($id)]);
            }
        }
    }
}
