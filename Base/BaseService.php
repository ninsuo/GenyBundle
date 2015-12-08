<?php

namespace GenyBundle\Base;

use GenyBundle\Traits\ContainerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

abstract class BaseService implements ContainerAwareInterface
{
    use ContainerTrait;
}
