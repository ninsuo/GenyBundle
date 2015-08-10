<?php

namespace Fuz\GenyBundle\Service;

use Fuz\GenyBundle\Entity\Form;

class Validator
{

    protected $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function validate($resource, array $data) {

        // ...

    }


}

