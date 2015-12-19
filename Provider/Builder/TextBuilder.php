<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\Extension\Core\Type;

class TextBuilder extends AbstractBuilder
{
    public function getName()
    {
        return 'text';
    }

    public function getDescription()
    {
        return 'geny.builders.text.description';
    }

    public function getDataType($name, array $options = null, $data = null)
    {
        return $this->getTypeBuilder($name, Type\TextType::class, $options, $data);
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
        return [];
    }
}
