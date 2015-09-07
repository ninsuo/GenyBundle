<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Provider\LoaderProvider;
use Fuz\GenyBundle\Provider\Loader\FileLoader;
use Fuz\GenyBundle\Provider\UnserializerProvider;
use Fuz\GenyBundle\Provider\Unserializer\JsonUnserializer;

class Geny
{
    protected $loader;
    protected $unserializer;
    protected $normalizer;
    protected $builder;
    protected $validator;
    protected $initializer;

    public function __construct(LoaderProvider $loader,
                                UnserializerProvider $unserializer,
                                Normalizer $normalizer,
                                Builder $builder,
                                Validator $validator,
                                Initializer $initializer)
    {
        $this->loader       = $loader;
        $this->unserializer = $unserializer;
        $this->normalizer   = $normalizer;
        $this->builder      = $builder;
        $this->validator    = $validator;
        $this->initializer  = $initializer;
    }

    public function load($resource, array $options = array())
    {
        $config = $this->getConfig($options);

        // 1- Content Loader (fs, db, ...)
        $contents = $this->loader->load($config['loader_type'], $resource);

        // 2- Unserializer (json, xml, ...)
        $data = $this->unserializer->unserialize($config['unserializer_type'], $contents);

        // 3- Geny Normalizer
        $form = $this->normalizer->normalizeForm($resource, $data);

        // 4- Symfony FormType Builder
        $type = $this->builder->build($form);

        // 5- Data Initializer
        $this->initializer->initialize($type, $form);

        return $type;
    }

    public function getConfig(array $options)
    {
        return array_merge(array(
            'loader_type'       => FileLoader::TYPE_FILE,
            'unserializer_type' => JsonUnserializer::FORMAT_JSON,
           ), $options);
    }
}
