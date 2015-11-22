<?php

namespace Fuz\GenyBundle\Data\Resources;

class Validator extends AbstractResource
{
    public function __toString()
    {
        return 'Validator:'.$this->getResource();
    }
}
