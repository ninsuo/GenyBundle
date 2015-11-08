<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Provider\Extension;
use Fuz\GenyBundle\Provider\Loader;
use Fuz\GenyBundle\Provider\Unserializer;
use Fuz\GenyBundle\Provider\Normalizer;
use Fuz\GenyBundle\Provider\Validator;

class Environment
{
    protected $extension;
    protected $loader;
    protected $unserializer;
    protected $normalizer;
    protected $builder;
    protected $initializer;
    protected $validator;

    public function __construct(
                                Extension    $extension,
                                Loader       $loader,
                                Unserializer $unserializer,
                                Normalizer   $normalizer,
                                Builder      $builder,
                                Validator    $validator,
                                Initializer  $initializer)
    {
        $this->extension    = $extension;
        $this->loader       = $loader;
        $this->unserializer = $unserializer;
        $this->normalizer   = $normalizer;
        $this->builder      = $builder;
        $this->initializer  = $initializer;
        $this->validator    = $validator;
    }

    public function prepare(ResourceInterface $resource)
    {
        if (ResourceInterface::STATE_INPROGRESS === $resource->getState()) {
            return false;
        }

        if (ResourceInterface::STATE_PENDING !== $resource->getState()) {
            return ResourceInterface::STATE_FAILED !== $resource->getState();
        }

        $resource->setState(ResourceInterface::STATE_INPROGRESS);

        try
        {
            $this->loader->load($resource);
            $this->unserializer->unserialize($resource);
            $this->normalizer->normalize($resource);
            $this->validator->boot($resource);

        } catch (\Exception $ex) {
            $resource->setState(ResourceInterface::STATE_FAILED);

            throw $ex;
        }

        $resource->setState(ResourceInterface::STATE_DONE);

        return true;
    }

}
