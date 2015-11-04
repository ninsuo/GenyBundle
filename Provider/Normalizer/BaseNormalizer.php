<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Base\BaseService;

abstract class BaseNormalizer extends BaseService implements NormalizerInterface
{
    public function validateConstraints(ResourceInterface $resource, array $required, array $optional)
    {
        // todo


    }
}