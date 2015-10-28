<?php

namespace Fuz\GenyBundle\Extension;

abstract class AbstractExtension implements ExtensionInterface
{
    const PRIORITY_LOW    = 100;
    const PRIORITY_MEDIUM = 50;
    const PRIORITY_HIGH   = 0;

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

    public function getPriority()
    {
        return self::PRIORITY_LOW;
    }
}
