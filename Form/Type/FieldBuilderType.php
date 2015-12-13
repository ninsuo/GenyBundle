<?php

namespace GenyBundle\Form\Type;

use GenyBundle\Base\BaseType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldBuilderType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('name', Type\TextType::class, [
               'attr'       => [
                   'placeholder' => 'geny.type.field.name.placeholder',
               ],
               'empty_data' => $this->get('translator')->trans('geny.builder.title.default', [], 'geny'),
               'label'      => 'geny.builder.title.label',
               'required'   => true,
           ])

           // ...

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
