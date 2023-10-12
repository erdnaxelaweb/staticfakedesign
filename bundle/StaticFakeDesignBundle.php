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

namespace ErdnaxelaWeb\StaticFakeDesignBundle;

use ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass\ChainGeneratorPass;
use ErdnaxelaWeb\StaticFakeDesignBundle\DependencyInjection\CompilerPass\ContentFieldGeneratorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StaticFakeDesignBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ContentFieldGeneratorPass());
        $container->addCompilerPass(new ChainGeneratorPass());
    }
}
