<?php

namespace GenyBundle\Form\Type;

use GenyBundle\Base\BaseType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

class BuilderType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('title', Type\TextType::class, [
               'attr'       => [
                   'placeholder' => 'geny.builder.title.placeholder',
               ],
               'empty_data' => $this->get('translator')->trans('geny.builder.title.default', [], 'geny'),
               'label'      => 'geny.builder.title.label',
               'required'   => true,
           ])
           ->add('description', Type\TextareaType::class, [
               'attr'       => [
                   'placeholder' => 'geny.builder.description.placeholder',
               ],
               'empty_data' => null,
               'label'      => 'geny.builder.description.label',
               'required'   => false,
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
