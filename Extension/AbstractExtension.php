<?php

namespace Fuz\GenyBundle\Extension;

abstract class AbstractExtension implements ExtensionInterface
{
    public function getTypes()
    {
        return array();
    }

    public function getOptions()
    {
        return array();
    }

    public function getValidators()
    {
        return array();
    }
}
