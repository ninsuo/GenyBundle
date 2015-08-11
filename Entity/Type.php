<?php

namespace Fuz\GenyBundle\Entity;

class Type
{
    const VISIBILITY_PUBLIC  = 'public';
    const VISIBILITY_PRIVATE = 'private';

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

    public function __construct()
    {
        $this->supportsOptions    = array();
        $this->supportsValidators = array();
        $this->visibility         = self::VISIBILITY_PUBLIC;
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
}
