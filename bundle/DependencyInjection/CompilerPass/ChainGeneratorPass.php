<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ChainGeneratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(! $container->has(ChainGenerator::class)) {
            return ;
        }

        $registry = $container->getDefinition(ChainGenerator::class);
        $services = $container->findTaggedServiceIds('erdnaxelaweb.static_fake_design.generator');
        foreach ($services as $id => $attributes) {
            $type = $attributes[0]['type'] ?? null;
            if($type) {
                $registry->addMethodCall(
                    'registerGenerator',
                    [
                        $type,
                        new Reference($id),
                    ]
                );
            }
        }
    }

}
