<?php

namespace GenyBundle\Traits;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

trait ContainerTrait
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
