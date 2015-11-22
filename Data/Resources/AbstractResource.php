<?php

namespace Fuz\GenyBundle\Data\Resources;

use Fuz\GenyBundle\Data\Validator;
use Symfony\Component\Form\FormInterface;

abstract class AbstractResource implements ResourceInterface
{
    protected $resource;
    protected $loader;
    protected $format;

    protected $isRoot;

    protected $loaded       = null;
    protected $unserialized = null;
    protected $normalized   = null;

    protected $form         = null;
    protected $validator    = null;

    protected $state        = self::STATE_PENDING;

    public function __construct($resource, $loader, $format, $isRoot = true)
    {
        $this->resource = $resource;
        $this->loader   = $loader;
        $this->format   = $format;
        $this->isRoot   = $isRoot;
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

    public function getLoader()
    {
        return $this->loader;
    }

    public function setLoader($loader)
    {
        $this->loader = $loader;

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

    public function isRoot()
    {
        return $this->isRoot;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
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

    public function setNormalized($object)
    {
        $this->normalized = $object;

        return $this;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setForm(FormInterface $form)
    {
        $this->form = $form;

        return $this;
    }
}
