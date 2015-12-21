<?php

namespace GenyBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class CollectionTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['allow_move', 'allow_duplicate']);

        $resolver->setDefaults([
            'allow_move'      => true,
            'allow_duplicate' => true,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['allow_move'] = $options['allow_move'];
        $view->vars['allow_duplicate'] = $options['allow_duplicate'];


    }

    public function getExtendedType()
    {
        return Type\CollectionType::class;
    }
}