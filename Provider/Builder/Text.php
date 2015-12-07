<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\Extension\Core\Type;

class Text extends AbstractBuilder
{
    public function getName()
    {
        return 'text';
    }

    public function getDescription()
    {
        return 'geny.builders.text.description';
    }

    public function getDataType($name, array $options = null, array $data = null)
    {
        return $this->getDataCoreType(Type\TextType::class, $name, $options, $data);
    }

    public function getDefaultData()
    {
        return $this->get('translator')->trans('geny.builders.text.default', [], 'geny');
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

