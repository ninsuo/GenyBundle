<?php

namespace GenyBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

class BuilderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('title', Type\TextType::class, array(
               'attr'       => array(
                   'placeholder' => 'geny.form.builder.title.placeholder',
               ),
               'empty_data' => 'geny.form.builder.title.default',
               'required'   => true,
           ))
           ->add('description', Type\TextareaType::class, array(
               'attr'       => array(
                   'placeholder' => 'geny.form.builder.description.placeholder',
               ),
               'empty_data' => null,
               'required'   => false,
           ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'GenyBundle\Entity\Form',
            'translation_domain' => 'geny',
        ));
    }
}
