<?php

namespace Fuz\GenyBundle\Data\Resources;

class Form extends AbstractResource
{
    public function __toString()
    {
        return 'Form:'.$this->getResource();
    }
}
