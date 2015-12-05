<?php

namespace GenyBundle\Provider\Type;

class Form extends AbstractType
{
    public function getName()
    {
        return 'choice';
    }

    public function isInternal()
    {
        return true;
    }
}

