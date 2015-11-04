<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\NormalizerException;

abstract class BaseNormalizer extends BaseService implements NormalizerInterface
{
    public function validateRequirements(ResourceInterface $resource, array $required, array $optional)
    {
        $keys = array_keys($resource->getUnserialized());

        // No required keys should be missing
        $missing = array_diff($required, $keys);
        if (count($missing)) {
            throw new NormalizerException("Required key(s) are missing in '%s': %s", $resource, implode(', ', $missing));
        }

        // No unexected keys should exist
        $unexpected = array_diff($keys, $required, $optional);
        if (count($unexpected)) {
            throw new NormalizerException("Unexpected key(s) are present in '%s': %s", $resource, implode(', ', $unexpected));
        }
    }
}