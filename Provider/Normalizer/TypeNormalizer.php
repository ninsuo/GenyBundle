<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Normalized\Type;

class TypeNormalizer extends BaseService implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Type';

    public function normalize(ResourceInterface $resource)
    {
        $type = new Type();
        $resource->setNormalized($type);

        return $type;
    }

    public function supports($class)
    {
        return self::CLASS_NAME === get_class($class);
    }

    public function getName()
    {
        return 'Type';
    }
}