<?php

namespace Fuz\GenyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('fuz_geny')
            ->children()
                ->arrayNode('validation_constraint_namespaces')
                    ->prototype('scalar')
                        ->defaultValue(array(
                            'Symfony\\Component\\Validator\\Constraints',
                        ))
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
