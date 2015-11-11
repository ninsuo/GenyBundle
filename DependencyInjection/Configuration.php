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
        $rootNode    = $treeBuilder->root('fuz_geny');

        $rootNode
           ->children()
               ->arrayNode('validation_constraint_namespaces')
                    ->defaultValue([
                        'Symfony\\Component\\Validator\\Constraints',
                    ])
                   ->prototype('scalar')
                   ->end()
               ->end()
           ->end()
        ->end();

        return $treeBuilder;
    }
}
