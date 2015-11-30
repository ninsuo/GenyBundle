<?php

namespace GenyBundle\Provider;

use GenyBundle\Base\BaseService;
use GenyBundle\Exception\TypeException;
use GenyBundle\Provider\Type\TypeInterface;

class Type extends BaseService
{
    protected $types = array();

    public function hasType($name)
    {
        return isset($this->types[$name]);
    }

    public function getType($name)
    {
        if (!isset($this->types[$name])) {
            throw new TypeException("Type '{$name}' not found.");
        }

        return $this->types[$name];
    }

    public function addType(TypeInterface $type)
    {
        $this->types[$type->getName()] = new TypeReference($type);
    }

    public function removeType($name)
    {
        unset($this->types[$name]);
    }

    public function setTypes(array $types)
    {
        foreach ($types as $type) {
            $this->addType($type);
        }
    }

    public function getTypes()
    {
        return $this->types;
    }
}
