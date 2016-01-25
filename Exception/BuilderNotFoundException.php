<?php

namespace GenyBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BuilderNotFoundException extends NotFoundHttpException
{
    public function __construct($name)
    {
        parent::__construct(sprintf("Builder '%s' not found", $name));
    }
}
