<?php

namespace Fuz\GenyBundle\Traits;

use Fuz\GenyBundle\Exception\ExtensionException;
use Fuz\GenyBundle\Extension\ExtensionInterface;

trait Extension
{
    protected $extensions = array();

    public function hasExtension($name)
    {
        return isset($this->extensions[$name]);
    }

    public function getExtension($name)
    {
        if (!isset($this->extensions[$name])) {
            throw new ExtensionException("Extension '{$name}' not found.");
        }

        return $this->extensions[$name];
    }

    public function addExtension(ExtensionInterface $extension)
    {
        $this->extensions[$extension->getName()] = $extension;
    }

    public function removeExtension($name)
    {
        unset($this->extensions[$name]);
    }

    public function setExtensions(array $extensions)
    {
        foreach ($extensions as $extension) {
            $this->addExtension($extension);
        }
    }

    public function getExtensions()
    {
        return $this->extensions;
    }
}
