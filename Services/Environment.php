<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Data\Resources\Form;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Provider\Extension;
use Fuz\GenyBundle\Provider\Loader;
use Fuz\GenyBundle\Provider\Unserializer;
use Fuz\GenyBundle\Provider\Normalizer;

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

    public function getType(Form $form, $data = null)
    {
        if ($form->getType()) {
            return $form->getType();
        }

        $normalized = $this->prepare($form);

        \Symfony\Component\VarDumper\VarDumper::dump($normalized);


        // Loading


    }

    public function getValidator(Form $form)
    {

    }

    public function prepare(ResourceInterface $resource)
    {
        $normalized = $resource->getNormalized();
        if (is_null($normalized)) {
            $this->loader->load($resource);
            $this->unserializer->unserialize($resource);
            $normalized = $this->normalizer->normalize($resource);
        }

        return $normalized;
    }
}
