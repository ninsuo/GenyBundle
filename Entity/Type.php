<?php

namespace Fuz\GenyBundle\Entity;

class Type
{
    const VISIBILITY_PUBLIC  = 'public';
    const VISIBILITY_PRIVATE = 'private';
    const COMPOUND_TRUE      = "true";
    const COMPOUND_FALSE     = "false";

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

    /**
     * @var string
     */
    protected $visibility;

    /**
     * @var boolean
     */
    protected $compound;

    public function __construct()
    {
        $this->supportsOptions    = array();
        $this->supportsValidators = array();
        $this->visibility         = self::VISIBILITY_PUBLIC;
        $this->compound           = false;
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
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @return boolean
     */
    public function isCompound()
    {
        return $this->compound;
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

    /**
     * @param string $visibility
     * @return Type
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @param boolean $compound
     * @return Type
     */
    public function setCompound($compound)
    {
        $this->compound = $compound;
        return $this;
    }

}
