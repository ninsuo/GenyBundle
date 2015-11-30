<?php

namespace GenyBundle\Data;

class Type
{
    protected $id;
    protected $name;
    protected $data;
    protected $options;
    protected $constraints;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function setConstraints(array $constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }
}
