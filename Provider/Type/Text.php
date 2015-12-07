<?php

namespace GenyBundle\Provider\Type;

use Symfony\Component\Form\Extension\Core\Type;

class Text extends AbstractType
{
    public function getName()
    {
        return 'text';
    }

    public function getDescription()
    {
        return 'geny.type.text.description';
    }

    public function getDataType($name, array $options = null, array $data = null)
    {
        return $this->getDataCoreType(Type\TextType::class, $name, $options, $data);
    }

    public function getDefaultData()
    {
        return $this->get('translator')->trans('geny.type.text.default', [], 'geny');
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

