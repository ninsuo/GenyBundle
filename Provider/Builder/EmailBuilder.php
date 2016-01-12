<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\Extension\Core\Type;
use GenyBundle\Constraint;

class EmailBuilder extends TextBuilder
{
    public function getName()
    {
        return 'email';
    }

    public function getDescription()
    {
        return 'geny.builders.email.description';
    }

    public function getDataType(Field $entity, $name, array $options, $data)
    {
        return $this->getBuilder($name, Type\EmailType::class, $options, $data);
    }

    public function supportsConstraints(Field $entity)
    {
        return array_merge([
            Constraint\EmailConstraint::class,
        ] , parent::supportsConstraints($entity));
    }
}
