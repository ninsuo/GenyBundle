<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\Extension\Core\Type;

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

    public function getDataType($name, array $options = null, $data = null)
    {
        return $this->getTypeBuilder($name, Type\ChoiceType::class, $options, $data);
    }

    public function getDefaultData()
    {
        return null;
    }

    public function getOptionsType()
    {
        return null;
    }

    public function getDefaultOptions()
    {
        return [];
    }

    public function getConstraintsType()
    {
    }

    public function getDefaultConstraints($data = null)
    {
    }
}
