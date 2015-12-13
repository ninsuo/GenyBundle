<?php

namespace GenyBundle\Form\Type;

use GenyBundle\Base\BaseType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormBuilderType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('title', Type\TextType::class, [
               'attr'       => [
                   'placeholder' => 'geny.type.form.title.placeholder',
               ],
               'empty_data' => $this->get('translator')->trans('geny.type.form.title.default', [], 'geny'),
               'label'      => 'geny.type.form.title.label',
               'required'   => true,
           ])
           ->add('description', Type\TextareaType::class, [
               'attr'       => [
                   'placeholder' => 'geny.type.form.description.placeholder',
               ],
               'empty_data' => null,
               'label'      => 'geny.type.form.description.label',
               'required'   => false,
           ])
           ->add('submit', Type\TextType::class, [
               'attr'       => [
                   'placeholder' => 'geny.type.form.submit.placeholder',
               ],
               'empty_data' => $this->get('translator')->trans('geny.type.form.submit.default', [], 'geny'),
               'label'      => 'geny.type.form.submit.label',
               'required'   => true,
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'GenyBundle\Entity\Form',
            'translation_domain' => 'geny',
        ]);
    }
}
