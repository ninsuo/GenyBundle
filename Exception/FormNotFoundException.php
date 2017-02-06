<?php

namespace GenyBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormNotFoundException extends NotFoundHttpException
{
    public function __construct($id)
    {
        parent::__construct(sprintf('Form %d not found', $id));
    }
}
