<?php

namespace Fuz\GenyBundle\Entity;

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
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $validation;

    /**
     * @var array
     */
    protected $fields;

    public function __construct()
    {
        $this->options    = array();
        $this->validation = array();
        $this->fields     = array();
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
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getValidation()
    {
        return $this->validation;
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

    /**
     * @param array $options
     * @return Form
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param array $validation
     * @return Form
     */
    public function setValidation(array $validation)
    {
        $this->validation = $validation;
        return $this;
    }
}
