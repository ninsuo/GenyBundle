<?php

namespace GenyBundle\Exception;

use GenyBundle\Base\BaseException;

class FormNotFoundException extends BaseException
{
    public function __construct($id)
    {
        parent::__construct(sprintf("Form %d not found", $id));
    }

}
