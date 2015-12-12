<?php

namespace GenyBundle\Traits;

use Symfony\Component\Form\Extension\Core\Type;

trait ConstraintsTrait
{
    abstract protected function getBuilder($name, $type, array $options = null, $data = null);


}
