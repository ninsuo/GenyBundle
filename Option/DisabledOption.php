<?php

namespace GenyBundle\Option;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

class DisabledOption implements OptionInterface
{
    public function getDefault(Field $entity)
    {
        return [
            'disabled' => false,
        ];
    }

    public function normalize(Field $entity, array $options)
    {
        $config = $entity->getOptions();

        if ($config['disabled']) {
            $options['disabled'] = true;
        }

        return $options;
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('disabled', Type\CheckboxType::class, [
               'label'       => 'geny.builders.option.disabled',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required'    => false,
        ]);
    }
}