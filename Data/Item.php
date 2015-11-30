<?php

namespace GenyBundle\Data;

class Item
{
    protected $id;
    protected $type;
    protected $field;
    protected $text;
    protected $image;

    public function getId()
    {
        return $this->id;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }
}
