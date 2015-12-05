<?php

namespace GenyBundle\Provider\Type;

use GenyBundle\Base\BaseService;

abstract class AbstractType extends BaseService implements TypeInterface
{
    public function getDescription()
    {
        return null;
    }

    public function isInternal()
    {
        return false;
    }
}