<?php

namespace Fuz\GenyBundle\Base;

use Symfony\Component\DependencyInjection\ContainerAware;

abstract class BaseService extends ContainerAware
{
    public function get($service) {
        return $this->container->get($service);
    }

    public function getParameter($parameter) {
        return $this->container->getParameter($parameter);
    }
}