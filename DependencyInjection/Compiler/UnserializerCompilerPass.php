<?php

namespace Fuz\GenyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class UnserializerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('geny.unserializer')) {
            return;
        }

        $definition = $container->findDefinition('geny.unserializer');
        $taggedServices = $container->findTaggedServiceIds('geny.unserializer');

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addUnserializer', array(new Reference($id)));
        }
    }
}
