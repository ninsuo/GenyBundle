<?php

namespace Fuz\GenyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class NormalizerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('geny.normalizer')) {
            return;
        }

        $definition = $container->findDefinition('geny.normalizer');
        $taggedServices = $container->findTaggedServiceIds('geny.normalizer');

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addNormalizer', array(new Reference($id)));
        }
    }
}
