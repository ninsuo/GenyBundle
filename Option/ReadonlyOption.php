<?php

namespace GenyBundle\Option;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

class ReadonlyOption implements OptionInterface
{
    public function getDefaults(Field $entity)
    {
        return [
            'readonly' => false,
        ];
    }

    public function normalize(Field $entity, array $options)
    {
        $config = $entity->getOptions();

        if ($config['readonly']) {
            $options['attr']['readonly'] = true;
        }

        return $options;
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('readonly', Type\CheckboxType::class, [
               'label'       => 'geny.builders.option.readonly',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required'    => false,
        ]);
    }
}
