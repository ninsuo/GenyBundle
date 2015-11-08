<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Normalized\Option;

class OptionNormalizer extends BaseService implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Option';

    public function normalize(ResourceInterface $resource)
    {
        $option = new Option();
        $resource->setNormalized($option);

        return $option;
    }

    public function supports($class)
    {
        return self::CLASS_NAME === get_class($class);
    }

    public function getName()
    {
        return 'Option';
    }
}