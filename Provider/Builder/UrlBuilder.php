<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\Extension\Core\Type;
use GenyBundle\Constraint;

class UrlBuilder extends TextBuilder
{
    public function getName()
    {
        return 'url';
    }

    public function getDescription()
    {
        return 'geny.builders.url.description';
    }

    public function getDataType(Field $entity, $name, array $options, $data)
    {
        return $this->getBuilder($name, Type\UrlType::class, $options, $data);
    }

    public function supportsConstraints(Field $entity)
    {
        return array_merge([
            Constraint\UrlConstraint::class,
        ], parent::supportsConstraints($entity));
    }
}
