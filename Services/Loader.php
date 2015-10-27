<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Exception\LoaderException;
use Fuz\GenyBundle\Loader\LoaderInterface;

class Loader extends BaseService
{
    protected $loaders = array();

    public function load($type, $resource)
    {
        foreach ($this->loaders as $loader) {
            if ($loader->supports($type)) {
                return $loader->load($resource);
            }
        }

        throw new LoaderException("Loader '{$type}' is not implemented.");
    }

    public function hasLoader($name)
    {
        return isset($this->loaders[$name]);
    }

    public function getLoader($name)
    {
        if (!isset($this->loaders[$name])) {
            throw new LoaderException("Loader '{$name}' not found.");
        }

        return $this->loaders[$name];
    }

    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[$loader->getName()] = $loader;
    }

    public function removeLoader($name)
    {
        unset($this->loaders[$name]);
    }

    public function setLoaders(array $loaders)
    {
        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    public function getLoaders()
    {
        return $this->loaders;
    }
}
