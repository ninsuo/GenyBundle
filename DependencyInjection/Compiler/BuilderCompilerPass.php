<?php

namespace GenyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BuilderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('geny.builder')) {
            return;
        }

        $definition = $container->findDefinition('geny.builder');
        $taggedServices = $container->findTaggedServiceIds('geny.builder');

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addBuilder', array(new Reference($id)));
        }
    }
}
