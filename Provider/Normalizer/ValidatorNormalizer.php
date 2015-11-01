<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;

class ValidatorNormalizer extends BaseService implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Validator';

    public function normalize($resource)
    {

    }

    public function supports($class)
    {
        return self::CLASS_NAME === get_class($class);
    }

    public function getName()
    {
        return 'Validator';
    }
}