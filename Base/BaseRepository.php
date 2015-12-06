<?php

namespace GenyBundle\Base;

use Doctrine\ORM\EntityRepository;
use GenyBundle\Traits\ContainerTrait;

abstract class BaseRepository extends EntityRepository
{
    use ContainerTrait;
}
