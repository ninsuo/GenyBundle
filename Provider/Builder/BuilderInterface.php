<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Entity\Field;

interface BuilderInterface
{
    public function getName();
    public function getDescription();

    public function getDataType(Field $entity, $name, array $options, $data);
    public function getDefaultData(Field $entity);

    public function supportsOptions(Field $entity);
    public function supportsConstraints(Field $entity);
}
