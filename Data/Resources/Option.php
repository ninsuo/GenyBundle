<?php

namespace Fuz\GenyBundle\Data\Resources;

class Option extends AbstractResource
{
    public function __toString()
    {
        return 'Option:' . $this->getResource();
    }
}

