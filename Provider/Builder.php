<?php

namespace GenyBundle\Provider;

use GenyBundle\Base\BaseService;
use GenyBundle\Exception\BuilderNotFoundException;
use GenyBundle\Provider\Builder\BuilderInterface;

class Builder extends BaseService
{
    protected $builders = array();

    public function hasBuilder($name)
    {
        return isset($this->builders[$name]);
    }

    public function getBuilder($name)
    {
        if (!isset($this->builders[$name])) {
            throw new BuilderNotFoundException($name);
        }

        return $this->builders[$name];
    }

    public function addBuilder(BuilderInterface $builder)
    {
        $this->builders[$builder->getName()] = $builder;
    }

    public function removeBuilder($name)
    {
        unset($this->builders[$name]);
    }

    public function setBuilders(array $builders)
    {
        foreach ($builders as $builder) {
            $this->addBuilder($builder);
        }
    }

    public function getBuilders()
    {
        return $this->builders;
    }
}
