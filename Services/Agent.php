<?php

namespace Fuz\GenyBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;

class Agent
{
    /**
     * @var ArrayCollection
     */
    protected $forms;

    /**
     * @var ArrayCollection
     */
    protected $types;

    /**
     * @var ArrayCollection
     */
    protected $options;

    /**
     * @var ArrayCollection
     */
    protected $validators;

    public function __construct()
    {
        $this->forms      = new ArrayCollection();
        $this->types      = new ArrayCollection();
        $this->options    = new ArrayCollection();
        $this->validators = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getForms()
    {
        return $this->forms;
    }

    /**
     * @return ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return ArrayCollection
     */
    public function getValidators()
    {
        return $this->validators;
    }

}
