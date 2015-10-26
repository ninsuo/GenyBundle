<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resource;
use Fuz\GenyBundle\Traits;

class Environment extends BaseService
{
    use Traits\Extension;
    use Traits\Loader;
    use Traits\Unserializer;

    protected $resources;

    public function getType(Resource $resource)
    {
        if ($resource->getType()) {
            return $resource->getType();
        }

        // 1- Content Loader (fs, db, ...)
        $contents = $this->load($resource->getLoader(), $resource->getResource());

        // 2- Unserializer (json, xml, ...)
        $data = $this->unserialize($resource->getFormat(), $contents);

        // ... to think (inject geny in all Resource and proceed from inside??)

    }

    public function getValidator(Resource $resource)
    {

    }

    protected function getConfig(array $options)
    {
        $config = $this->container->getParameter('geny');

        return array_merge(array(
            'loader' => $config['default_loader'],
            'format' => $config['default_format'],
           ), $options);
    }

    /*
    protected $normalizer;
    protected $builder;
    protected $validator;
    protected $initializer;

    public function __construct(
                                Normalizer $normalizer,
                                Builder $builder,
                                Validator $validator,
                                Initializer $initializer)
    {
        $this->normalizer   = $normalizer;
        $this->builder      = $builder;
        $this->validator    = $validator;
        $this->initializer  = $initializer;
    }

    public function getType()
    {

    }

    public function load($resource, array $options = array())
    {
        $config = $this->getConfig($options);

        // 1- Content Loader (fs, db, ...)
        $contents = $this->loader->load($config['loader_type'], $resource);

        // 2- Unserializer (json, xml, ...)
        $data = $this->unserializer->unserialize($config['unserializer_type'], $contents);


        // FieldNormalizer
        // TypeNormalizer
        // OptionNormalizer
        // ValidatorNormalizer


        // 3- Geny Normalizer
        $form = $this->normalizer->normalizeForm($resource, $data);

        // 4- Symfony FormType Builder
        $type = $this->builder->build($form);

        // 5- Data Initializer
        $this->initializer->initialize($type, $form);

        return $type;
    }


    */
}
