<?php

namespace Fuz\GenyBundle\Data\Resources;

class Type extends AbstractResource
{
    public function __toString()
    {
        return 'Type:' . $this->getResource();
    }
}

