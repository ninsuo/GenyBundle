<?php

namespace GenyBundle\Constraint;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;

interface ConstraintInterface
{
    public function getDefault(Field $entity);
    public function normalize(Field $entity);
    public function getBuilder(FormBuilderInterface $builder, Field $entity, $data = null);
}