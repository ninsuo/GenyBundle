<?php

namespace Fuz\GenyBundle\Traits;

use Fuz\GenyBundle\Exception\UnserializerException;
use Fuz\GenyBundle\Unserializer\UnserializerInterface;

trait Unserializer
{
    protected $unserializers = array();

    public function unserialize($type, $contents)
    {
        foreach ($this->unserializers as $unserializer) {
            if ($unserializer->supports($type)) {
                return $unserializer->unserialize($contents);
            }
        }

        throw new UnserializerException("Unserializer '{$type}' is not implemented.");
    }

    public function hasUnserializer($name)
    {
        return isset($this->unserializers[$name]);
    }

    public function getUnserializer($name)
    {
        if (!isset($this->unserializers[$name])) {
            throw new UnserializerException("Unserializer '{$name}' not found.");
        }

        return $this->unserializers[$name];
    }

    public function addUnserializer(UnserializerInterface $unserializer)
    {
        $this->unserializers[$unserializer->getName()] = $unserializer;
    }

    public function removeUnserializer($name)
    {
        unset($this->unserializers[$name]);
    }

    public function setUnserializers(array $unserializers)
    {
        foreach ($unserializers as $unserializer) {
            $this->addUnserializer($unserializer);
        }
    }

    public function getUnserializers()
    {
        return $this->unserializers;
    }
}
