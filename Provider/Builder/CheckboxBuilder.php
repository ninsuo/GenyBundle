<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;
use GenyBundle\Option;
use GenyBundle\Constraint;
use Symfony\Component\Form\Extension\Core\Type;

class CheckboxBuilder extends AbstractBuilder
{
    public function getName()
    {
        return 'checkbox';
    }

    public function getDescription()
    {
        return 'geny.builders.checkbox.description';
    }

    public function getCategory()
    {
        return 'geny.builders.category.checkbox';
    }

    public function getDataType(Field $entity, $name, array $options, $data)
    {
        return $this->getBuilder($name, Type\CheckboxType::class, $options, $data);
    }

    public function getDefaultData(Field $entity)
    {
        return null;
    }

    public function supportsOptions(Field $entity)
    {
        return [
          //  Option\ChoicesOption::class,

            // choices_as_values => true
        ];
    }

    public function supportsConstraints(Field $entity)
    {
        return [
         //   Option\ChoicesConstraint::class,
        ];
    }
}
