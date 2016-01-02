<?php

namespace GenyBundle\Option;

use GenyBundle\Entity\Field;
use Symfony\Component\Form\FormBuilderInterface;

interface OptionInterface
{
    public function getDefault(Field $entity);
    public function normalize(Field $entity, array $options);
    public function build(FormBuilderInterface $builder, Field $entity, $data = null);
}
