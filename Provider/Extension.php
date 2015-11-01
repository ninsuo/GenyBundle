<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Exception\ExtensionException;
use Fuz\GenyBundle\Provider\Extension\ExtensionInterface;

class Extension extends BaseService
{
    protected $extensions = array();
    protected $ordered    = true;

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
        $this->ordered                           = false;
    }

    public function removeExtension($name)
    {
        unset($this->extensions[$name]);
        $this->ordered = false;
    }

    public function setExtensions(array $extensions)
    {
        foreach ($extensions as $extension) {
            $this->addExtension($extension);
        }
    }

    public function getExtensions()
    {
        if (!$this->ordered) {
            usort($this->extensions, function(ExtensionInterface $a, ExtensionInterface $b) {
                return $a->getPriority() == $b->getPriority() ? 0 : $a->getPriority() > $b->getPriority() ? 1 : -1;
            });
            $this->ordered = true;
        }

        return $this->extensions;
    }
}
