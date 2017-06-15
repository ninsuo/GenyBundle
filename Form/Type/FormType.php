<?php

namespace GenyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GenyBundle\Entity\Form;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('form_builder', FormBuilderType::class, [
               'data_class' => Form::class,
               'label' => false,
           ])
           ->add('submit_builder', SubmitBuilderType::class, [
               'data_class' => Form::class,
               'label' => false,
           ])
           ->add('save', Type\SubmitType::class, [
               'label' => 'geny.type.form.save.label',
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'geny',
        ]);
    }
}
