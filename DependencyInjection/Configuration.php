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

    public function getBuiltInTypes()
    {
        return array(
            'base' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/base.json',
                'format'   => 'json',
            ),
            'button' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/button.json',
                'format'   => 'json',
            ),
            'checkbox' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/checkbox.json',
                'format'   => 'json',
            ),
            'choice' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/choice.json',
                'format'   => 'json',
            ),
            'collection' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/collection.json',
                'format'   => 'json',
            ),
            'container' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/container.json',
                'format'   => 'json',
            ),
            'form' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/form.json',
                'format'   => 'json',
            ),
            'keyvalue' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/keyvalue.json',
                'format'   => 'json',
            ),
            'list' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/list.json',
                'format'   => 'json',
            ),
            'number' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/number.json',
                'format'   => 'json',
            ),
            'submit' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/submit.json',
                'format'   => 'json',
            ),
            'text' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/text.json',
                'format'   => 'json',
            ),
            'textarea' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/types/textarea.json',
                'format'   => 'json',
            ),
        );
    }

    public function getBuiltInOptions()
    {
        return array(
            'action' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/action.json',
                'format'   => 'json',
            ),
            'allow_add' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/allow_add.json',
                'format'   => 'json',
            ),
            'allow_delete' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/allow_delete.json',
                'format'   => 'json',
            ),
            'always_empty' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/always_empty.json',
                'format'   => 'json',
            ),
            'attr' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/attr.json',
                'format'   => 'json',
            ),
            'choices' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/choices.json',
                'format'   => 'json',
            ),
            'disabled' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/disabled.json',
                'format'   => 'json',
            ),
            'empty_value' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/empty_value.json',
                'format'   => 'json',
            ),
            'expanded' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/expanded.json',
                'format'   => 'json',
            ),
            'grouping' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/grouping.json',
                'format'   => 'json',
            ),
            'invalid_message' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/invalid_message.json',
                'format'   => 'json',
            ),
            'label' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/label.json',
                'format'   => 'json',
            ),
            'label_attr' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/label_attr.json',
                'format'   => 'json',
            ),
            'max_length' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/max_length.json',
                'format'   => 'json',
            ),
            'method' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/method.json',
                'format'   => 'json',
            ),
            'multiple' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/multiple.json',
                'format'   => 'json',
            ),
            'precision' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/precision.json',
                'format'   => 'json',
            ),
            'preferred_choices' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/preferred_choices.json',
                'format'   => 'json',
            ),
            'read_only' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/read_only.json',
                'format'   => 'json',
            ),
            'required' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/required.json',
                'format'   => 'json',
            ),
            'rounding_mode' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/rounding_mode.json',
                'format'   => 'json',
            ),
            'trim' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/trim.json',
                'format'   => 'json',
            ),
            'value' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/options/value.json',
                'format'   => 'json',
            ),
        );
    }

    public function getBuiltInValidators()
    {
        return array(
            'choice' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/validators/choice.json',
                'format'   => 'json',
            ),
            'type' => array(
                'loader'   => FileLoader::TYPE_FILE,
                'resource' => '@FuzGenyBundle/Resources/geny/validators/type.json',
                'format'   => 'json',
            ),
        );
    }

}
