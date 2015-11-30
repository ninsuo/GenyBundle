<?php

namespace GenyBundle\Data;

class Field
{
    protected $id;
    protected $name;
    protected $type;
    protected $label;
    protected $hint;
    protected $required;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getHint()
    {
        return $this->hint;
    }

    public function setHint($hint)
    {
        $this->hint = $hint;

        return $this;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }
}
