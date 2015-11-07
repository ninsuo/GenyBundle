<?php

namespace Fuz\GenyBundle\Data\Normalized;

use Doctrine\Common\Collections\ArrayCollection;
use Fuz\GenyBundle\Data\Resources\Type;

class Form implements NormalizedInterface
{
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

    /**
     * @var mixed
     */
    protected $data;

    public function __construct()
    {
        $this->options    = new ArrayCollection();
        $this->validation = new ArrayCollection();
        $this->fields     = new ArrayCollection();
        $this->data       = null;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return Type
     */
    public function getType()
    {
        return $this->type;
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
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Form
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
