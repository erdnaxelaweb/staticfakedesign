<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesignBundle;

use ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass\BlockFieldGeneratorPass;
use ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass\ChainGeneratorPass;
use ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass\ContentFieldGeneratorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StaticFakeDesignBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ContentFieldGeneratorPass());
        $container->addCompilerPass(new BlockFieldGeneratorPass());
        $container->addCompilerPass(new ChainGeneratorPass());
    }
}
