<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;
use GenyBundle\Option;
use GenyBundle\Constraint;
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

    public function getCategory()
    {
        return 'geny.builders.category.text';
    }

    public function getDataType(Field $entity, $name, array $options, $data)
    {
        return $this->getBuilder($name, Type\TextType::class, $options, $data);
    }

    public function getDefaultData(Field $entity)
    {
        return;
    }

    public function supportsOptions(Field $entity)
    {
        return [
            Option\TrimOption::class,
            Option\ReadonlyOption::class,
            Option\DisabledOption::class,
        ];
    }

    public function supportsConstraints(Field $entity)
    {
        return [
            Constraint\RegexesConstraint::class,
            Constraint\ExpressionConstraint::class,
        ];
    }
}
