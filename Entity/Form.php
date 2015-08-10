<?php

namespace Fuz\GenyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Form
{

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Type
     */
    protected $type;

    /**
     * @var ArrayCollection
     */
    protected $options;

    /**
     * @var ArrayCollection
     */
    protected $validation;

    /**
     * @var ArrayCollection
     */
    protected $fields;

    public function __construct()
    {
        $this->options    = new ArrayCollection();
        $this->validation = new ArrayCollection();
        $this->fields     = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
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
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @return ArrayCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $resource
     * @return Form
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @param string $name
     * @return Form
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Type $type
     * @return Form
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

}
