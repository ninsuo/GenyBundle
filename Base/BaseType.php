<?php

namespace GenyBundle\Base;

use GenyBundle\Traits\ContainerTrait;
use Symfony\Component\Form\AbstractType;

abstract class BaseType extends AbstractType
{
    use ContainerTrait;
}
