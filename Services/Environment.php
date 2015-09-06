<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Agent\Agent;
use Fuz\GenyBundle\Services\Loader\FileLoader;

class Environment
{
    protected $agent;
    protected $loader;
    protected $unserializer;
    protected $normalizer;
    protected $builder;
    protected $validator;
    protected $initializer;

    public function __construct(Agent $agent, Loader $loader, Unserializer $unserializer, Normalizer $normalizer, Builder $builder, Validator $validator, Initializer $initializer)
    {
        $this->agent        = $agent;
        $this->loader       = $loader;
        $this->unserializer = $unserializer;
        $this->normalizer   = $normalizer;
        $this->builder      = $builder;
        $this->validator    = $validator;
        $this->initializer  = $initializer;
    }

    public function load($path, array $options = array())
    {
        $config = $this->getConfig($options);

        // 1- Content Loader (fs, db, ...)
        $contents = $this->loader->load($config['loader_type'], $path);

        // 2- Unserializer (json, xml, ...)
        $data = $this->unserializer->unserialize($path, 'json', $contents);

        // 3- Geny Normalizer
        $form = $this->normalizer->normalizeForm($path, $data);

        // 4- Symfony FormType Builder
        $type = $this->builder->build($form);

        // 5- Data Initializer
        $this->initializer->initialize($type, $form);

        return $type;
    }

    public function getConfig(array $options)
    {
        return array_merge(array(
            'loader_type' => FileLoader::TYPE_FILE,
        ), $options);
    }
}
