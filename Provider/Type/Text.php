<?php

namespace GenyBundle\Provider\Type;

class Text extends AbstractType
{
    public function getName()
    {
        return 'text';
    }

    public function getDescription()
    {
        return 'geny.field.text.description';
    }
}

