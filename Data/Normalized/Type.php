<?php

namespace Fuz\GenyBundle\Data\Normalized;

use Doctrine\Common\Collections\ArrayCollection;

class Type implements TypeInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $mainOptions;

    /**
     * @var ArrayCollection
     */
    protected $advancedOptions;

    /**
     * @var ArrayCollection
     */
    protected $mainValidators;

    /**
     * @var ArrayCollection
     */
    protected $advancedValidators;

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
        $this->mainOptions     = new ArrayCollection();
        $this->advancedOptions = new ArrayCollection();

        $this->mainValidators     = new ArrayCollection();
        $this->advancedValidators = new ArrayCollection();

        $this->visibility = self::VISIBILITY_PUBLIC;
        $this->compound   = false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return ArrayCollection
     */
    public function getMainOptions()
    {
        return $this->mainOptions;
    }

    /**
     * @return ArrayCollection
     */
    public function getAdvancedOptions()
    {
        return $this->advancedOptions;
    }

    /**
     * @return ArrayCollection
     */
    public function getMainValidators()
    {
        return $this->mainValidators;
    }

    /**
     * @return ArrayCollection
     */
    public function getAdvancedValidators()
    {
        return $this->advancedValidators;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
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
     * @return boolean
     */
    public function isCompound()
    {
        return $this->compound;
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
