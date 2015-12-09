<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\Extension\Core\Type;

class Choice extends AbstractBuilder
{
    public function getName()
    {
        return 'choice';
    }

    public function getDescription()
    {
        return 'geny.builders.choice.description';
    }

    public function getDataType($name, array $options = null, array $data = null)
    {
        return $this->getDataCoreType(Type\ChoiceType::class, $name, $options, $data);
    }

    public function getDefaultData()
    {
    }

    public function getOptionsType()
    {
    }

    public function getDefaultOptions()
    {
    }

    public function getConstraintsType()
    {
    }

    public function getDefaultConstraints()
    {
    }
}
