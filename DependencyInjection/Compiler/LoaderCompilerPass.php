<?php

namespace Fuz\GenyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('geny')) {
            return;
        }

        $definition = $container->findDefinition('geny.loader');
        $taggedServices = $container->findTaggedServiceIds('geny.loader');

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addLoader', array(new Reference($id)));
        }
    }
}
