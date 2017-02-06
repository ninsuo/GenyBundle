<?php

namespace GenyBundle\Form\Type;

use GenyBundle\Base\BaseType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubmitBuilderType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('submit', Type\TextType::class, [
               'attr' => [
                   'placeholder' => 'geny.type.submit.submit.placeholder',
               ],
               'empty_data' => $this->get('translator')->trans('geny.type.submit.submit.default', [], 'geny'),
               'label' => 'geny.type.submit.submit.label',
               'required' => true,
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'GenyBundle\Entity\Form',
            'translation_domain' => 'geny',
        ]);
    }
}
