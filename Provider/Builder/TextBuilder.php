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

    public function getDataType($name, array $options = null, array $data = null)
    {
        return $this->TypeBuilder($name, Type\TextType::class, $options, $data);
    }

    public function getDefaultData()
    {
        return $this->get('translator')->trans('geny.builders.text.default', [], 'geny');
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
        return $this->getConstraintsBuilder()
           ->add($this->buildConstraintEmail())
           ->add($this->buildConstraintUrl())
           ->add($this->buildConstraintIp())
           ->add($this->buildConstraintUuid())
           ->add($this->buildConstraintLength())
           ->add($this->buildConstraintRegex())
           ->add($this->buildConstraintExpression())
        ;
    }

    public function getDefaultConstraints()
    {
        return [];
    }
}
