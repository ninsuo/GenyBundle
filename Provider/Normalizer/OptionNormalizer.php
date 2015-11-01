<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;

class OptionNormalizer extends BaseService implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Option';

    public function normalize($resource)
    {

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