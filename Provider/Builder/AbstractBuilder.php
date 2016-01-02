<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Base\BaseService;
use GenyBundle\Traits\FormTrait;

abstract class AbstractBuilder extends BaseService implements BuilderInterface
{
    use FormTrait;
}
