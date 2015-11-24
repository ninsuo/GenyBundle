<?php

namespace GenyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TypeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('geny.type')) {
            return;
        }

        $definition = $container->findDefinition('geny.type');
        $taggedServices = $container->findTaggedServiceIds('geny.type');

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addType', array(new Reference($id)));
        }
    }
}
