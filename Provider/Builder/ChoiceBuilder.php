<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use GenyBundle\Entity\Field;

class ChoiceBuilder extends AbstractBuilder
{
    public function getName()
    {
        return 'choice';
    }

    public function getDescription()
    {
        return 'geny.builders.choice.description';
    }

    public function getDataType(Field $entity)
    {
        $name                   = $entity->getName();
        $data                   = $entity->getData();
        $options                = $entity->getOptions();
        $options['constraints'] = $entity->getConstraints();

        return $this->getBuilder($name, Type\ChoiceType::class, $options, $data);
    }

    public function getDefaultData()
    {
        return null;
    }

    public function getOptionsType(Field $entity, $data)
    {
        return null;
    }

    public function getDefaultOptions()
    {
        return [
            'choices_as_values' => true,
        ];
    }

    public function getConstraintsType(Field $entity, $data)
    {
    }

    public function getDefaultConstraints()
    {
    }
}
