<?php

namespace Fuz\GenyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This type can contain a list of repeated fields.
 */
class ListType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $options['type'] should contain at last 1 field

        $builder
           ->add('list', 'collection', array(
               'type'           => $options['type'],
               'allow_add'      => true,
               'allow_delete'   => true,
               'prototype'      => true,
               'required'       => false,
           ))
        ;

//        $builder->get('list')
//            ->addModelTransformer(new CallbackTransformer(
//                function (array $original) {
//                },
//                function (array $submitted) {
//
//                }
//            ))
//        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'type' => 'text',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'list';
    }
}
