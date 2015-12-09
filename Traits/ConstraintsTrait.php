<?php

namespace GenyBundle\Traits;

use Symfony\Component\Form\Extension\Core\Type;

trait ConstraintsTrait
{
    abstract protected function getBuilder($name, $type, array $options = null, $data = null);

    protected function buildConstraintEmail()
    {

    }

    protected function buildConstraintExpression()
    {

    }

    protected function buildConstraintIp()
    {

    }

    protected function buildConstraintLength()
    {

    }

    protected function buildConstraintRegex()
    {

    }

    protected function buildConstraintUrl()
    {

    }

    protected function buildConstraintUuid()
    {

    }
}
