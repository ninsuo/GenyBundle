<?php

namespace GenyBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FieldNotFoundException extends NotFoundHttpException
{
    public function __construct($id)
    {
        parent::__construct(sprintf("Field %d not found", $id));
    }

}
