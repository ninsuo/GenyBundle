<?php

namespace Fuz\GenyBundle\Entity;

class Type
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $supportsOptions;

    /**
     * @var array
     */
    protected $supportsValidators;

    public function __construct()
    {
        $this->supportsOptions = array();
        $this->supportsValidators = array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getSupportsOptions()
    {
        return $this->supportsOptions;
    }

    /**
     * @return array
     */
    public function getSupportsValidators()
    {
        return $this->supportsValidators;
    }

    /**
     * @param string $name
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param array $supportsOptions
     * @return Type
     */
    public function setSupportsOptions(array $supportsOptions)
    {
        $this->supportsOptions = $supportsOptions;
        return $this;
    }

    /**
     * @param array $supportsValidators
     * @return Type
     */
    public function setSupportsValidators(array $supportsValidators)
    {
        $this->supportsValidators = $supportsValidators;
        return $this;
    }
}
