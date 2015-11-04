<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Exception\UnserializerException;
use Fuz\GenyBundle\Provider\Unserializer\UnserializerInterface;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;

class Unserializer extends BaseService
{
    protected $unserializers = array();

    public function unserialize(ResourceInterface $resource)
    {
        if (is_null($resource->getLoaded())) {
            throw new UnserializerException("Resource should be loaded before being unserialized.");
        }

        if (!is_null($resource->getUnserialized())) {
            return $resource->getUnserialized();
        }

        $format = $resource->getFormat();
        $contents = $resource->getLoaded();

        foreach ($this->unserializers as $unserializer) {
            if ($unserializer->supports($format)) {
                $array = $unserializer->unserialize($contents);
                $resource->setUnserialized($array);

                return $array;
            }
        }

        throw new UnserializerException("Unserializer '{$format}' is not implemented.");
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