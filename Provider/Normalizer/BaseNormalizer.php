<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\BaseException;
use Fuz\GenyBundle\Exception\NormalizerException;

abstract class BaseNormalizer extends BaseService implements NormalizerInterface
{
    public function validateRequirements(ResourceInterface $resource, array $required, array $optional, array $path = array())
    {
        $array = $resource->getUnserialized();
        foreach ($path as $key) {
            $array = $array[$key];
        }
        $keys = array_keys($array);

        // No required keys should be missing
        $missing = array_diff($required, $keys);
        if (count($missing)) {
            throw new NormalizerException(sprintf("Required key(s) are missing in '%s': %s", $resource, implode(', ', $missing)));
        }

        // No unexected keys should exist
        $unexpected = array_diff($keys, $required, $optional);
        if (count($unexpected)) {
            throw new NormalizerException(sprintf("Unexpected key(s) are present in '%s': %s", $resource, implode(', ', $unexpected)));
        }
    }

    public function normalizeName(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!preg_match("/^[0-9a-zA-Z_-]+$/", $array['name'])) {
            throw new NormalizerException(sprintf("Resource '%s' has an invalid name: %s.", $resource, $array['name']));
        }

        $object->setName($array['name']);
    }

    public function throwContextException(ResourceInterface $resource, BaseException $ex)
    {
        return new NormalizerException(sprintf(
           "'%s' < [%s] %s",
           $resource,
           substr($c = get_class($ex), strrpos($c, "\\") + 1),
           $ex->getMessage()
        ));
    }
}
