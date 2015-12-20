<?php

namespace GenyBundle\Exception;

class BuilderNotFoundException extends \LogicException
{
    public function __construct($name)
    {
        parent::__construct(sprintf("Builder '%s' not found", $name));
    }
}
