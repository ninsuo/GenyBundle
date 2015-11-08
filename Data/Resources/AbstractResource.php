<?php

namespace Fuz\GenyBundle\Data\Resources;

use Fuz\GenyBundle\Data\Normalized\NormalizedInterface;
use Fuz\GenyBundle\Provider\Validator\ValidatorInterface;

abstract class AbstractResource implements ResourceInterface
{
    protected $loader;
    protected $resource;
    protected $format;

    protected $isParent;

    protected $loaded       = null;
    protected $unserialized = null;
    protected $normalized   = null;

    protected $type         = null;
    protected $validator    = null;

    protected $state        = self::STATE_PENDING;

    public function __construct($loader, $resource, $format, $isParent = true)
    {
        $this->loader   = $loader;
        $this->resource = $resource;
        $this->format   = $format;
        $this->isParent = $isParent;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    public function setLoader($loader)
    {
        $this->loader = $loader;
        return $this;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function isParent()
    {
        return $this->isParent;
    }

    public function getLoaded()
    {
        return $this->loaded;
    }

    public function setLoaded($contents)
    {
        $this->loaded = $contents;

        return $this;
    }

    public function getUnserialized()
    {
        return $this->unserialized;
    }

    public function setUnserialized(array $array)
    {
        $this->unserialized = $array;
        return $this;
    }

    public function getNormalized()
    {
        return $this->normalized;
    }

    public function setNormalized(NormalizedInterface $object)
    {
        $this->normalized = $object;
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

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state) {
        if (!in_array($state, [
            self::STATE_PENDING,
            self::STATE_INPROGRESS,
            self::STATE_DONE,
            self::STATE_FAILED
        ])) {
            throw new \LogicException(sprintf("Invalid state given: %s", $state));
        }

        $this->state = $state;
        return $this;
    }
}
