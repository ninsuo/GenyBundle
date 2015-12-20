<?php

namespace GenyBundle\Form\Type;

use GenyBundle\Base\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionEntryType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['fields'] as $field) {
            $builder->add($field['name'], $field['type'], $field['options']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'fields' => [],
        ]);
    }
}
