<?php

namespace GenyBundle\Base;

use GenyBundle\Traits\ContainerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Form\AbstractType;

abstract class BaseType extends AbstractType implements ContainerAwareInterface
{
    use ContainerTrait;
}
