<?php

namespace GenyBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type;


// interesting reading: http://symfony.com/doc/current/cookbook/form/create_form_type_extension.html

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

    public function getExtendedType()
    {
        return Type\CollectionType::class;
    }
}