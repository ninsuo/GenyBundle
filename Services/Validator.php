<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Agent\Agent;
use Fuz\GenyBundle\Entity\Form;

class Validator
{

    protected $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function validate($resource, $parameters) {

        // ...

    }


}

