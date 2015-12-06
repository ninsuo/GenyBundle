<?php

namespace GenyBundle\Base;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\AbstractType;

abstract class BaseType extends AbstractType
{
    use ContainerAwareTrait;

    public function get($service)
    {
        return $this->container->get($service);
    }

    public function getParameter($parameter)
    {
        return $this->container->getParameter($parameter);
    }
}
