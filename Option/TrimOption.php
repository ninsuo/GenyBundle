<?php

namespace GenyBundle\Option;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

class TrimOption implements OptionInterface
{
    public function getDefaults(Field $entity)
    {
        return [
            'trim' => true,
        ];
    }

    public function normalize(Field $entity, array $options)
    {
        $config = $entity->getOptions();

        $options['trim'] = $config['trim'];

        return $options;
    }

    public function build(FormBuilderInterface $builder, Field $entity, $data = null)
    {
        $builder
           ->add('trim', Type\CheckboxType::class, [
               'label'       => 'geny.builders.option.trim',
               'constraints' => [
                   new Assert\Type(['type' => 'bool']),
               ],
               'required'    => false,
        ]);
    }
}
