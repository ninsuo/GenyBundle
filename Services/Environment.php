<?php

namespace Fuz\GenyBundle\Services;

class Environment
{

    protected $agent;
    protected $loader;
    protected $unserializer;
    protected $normalizer;
    protected $builder;
    protected $validator;

    public function __construct(Agent $agent, Loader $loader, Unserializer $unserializer, Normalizer $normalizer, Builder $builder, Validator $validator)
    {
        $this->agent        = $agent;
        $this->loader       = $loader;
        $this->unserializer = $unserializer;
        $this->normalizer   = $normalizer;
        $this->builder      = $builder;
        $this->validator    = $validator;
    }

    public function load($path)
    {
        // 1- Content Loader (fs, db, ...)
        $contents = $this->loader->load('file', $path);

        // 2- Unserializer (json, xml, ...)
        $data = $this->unserializer->unserialize($path, 'json', $contents);

        // 3- Geny Normalizer
        $form = $this->normalizer->normalizeForm($path, $data);

        // 4- Symfony FormType Builder
        $type = $this->builder->build($form);

        return $type;
    }


}
