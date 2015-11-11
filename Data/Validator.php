<?php

namespace Fuz\GenyBundle\Data;

use Doctrine\Common\Collections\ArrayCollection;

class Validator
{
    protected $constraints;
    protected $violations;

    public function __construct()
    {
        $this->constraints = new ArrayCollection();
        $this->violations = new ArrayCollection();
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getViolations()
    {
        return $this->violations;
    }
}
