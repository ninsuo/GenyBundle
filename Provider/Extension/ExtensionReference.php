<?php

namespace Fuz\GenyBundle\Provider\Extension;

class ExtensionReference implements ExtensionInterface
{
    protected $base;
    protected $types;
    protected $options;
    protected $validators;

    public function __construct(ExtensionInterface $base)
    {
        $this->base       = $base;
        $this->types      = $base->getTypes();
        $this->options    = $base->getOptions();
        $this->validators = $base->getValidators();
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getValidators()
    {
        return $this->validators;
    }

    public function getPriority()
    {
        return $this->base->getPriority();
    }

    public function getName()
    {
        return $this->base->getName();
    }
}