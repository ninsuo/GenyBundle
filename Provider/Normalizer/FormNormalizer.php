<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;

class FormNormalizer extends BaseService implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Form';

    public function normalize($resource)
    {

    }

    public function supports($class)
    {
        return self::CLASS_NAME === $class;
    }

    public function getName()
    {
        return 'Form';
    }
}