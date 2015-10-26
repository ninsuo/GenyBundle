<?php

namespace Fuz\GenyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Fuz\GenyBundle\Provider\Loader\FileLoader;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('fuz_geny');

        $node = $rootNode->children();

        // todo:
        // default_loader (default FileLoader::TYPE_FILE)
        // default_format (default JsonUnserializer::FORMAT_JSON)

        $keys = array(
            'extra_types',
            'extra_options',
            'extra_validators',
        );

        foreach ($keys as $key)
        {
        }

                $node->arrayNode('extra_types')
                     ->defaultValue(array())
                     ->useAttributeAsKey('name')
                     ->prototype('array')
                         ->children()
                             ->integerNode('loader')
                                 ->isRequired()
                             ->end()
                             ->integerNode('resource')
                                 ->isRequired()
                             ->end()
                             ->integerNode('format')
                                 ->isRequired()
                             ->end()
                         ->end()
                     ->end()
        ;

        return $treeBuilder;
    }
}
