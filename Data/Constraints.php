<?php

namespace Fuz\GenyBundle\Data;

use Doctrine\Common\Collections\ArrayCollection;

class Constraints
{
    protected $constraints;

    public function __construct()
    {
        $this->constraints = new ArrayCollection();
    }

    public function getConstraints()
    {
        return $this->constraints;
    }
}
