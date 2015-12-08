<?php

namespace GenyBundle\Base;

use Doctrine\ORM\EntityRepository;
use GenyBundle\Traits\ContainerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

abstract class BaseRepository extends EntityRepository implements ContainerAwareInterface
{
    use ContainerTrait;
}
