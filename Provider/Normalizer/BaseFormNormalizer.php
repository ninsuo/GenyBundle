<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\NormalizerException;
use Fuz\GenyBundle\Exception\TypeException;

abstract class BaseFormNormalizer extends BaseNormalizer implements NormalizerInterface
{
    public function normalizeForm(ResourceInterface $resource)
    {
        if (is_null($object = $resource->getNormalized())) {
            throw new NormalizerException("An empty normalized object should be created before normalizing data.");
        }

        $array = $resource->getUnserialized();

        $required = ['name', 'type'];
        $optional = ['options', 'validation', 'fields', 'data'];
        $this->validateRequirements($resource, $required, $optional);

        if (!preg_match("/^[0-9a-zA-Z_-]+$/", $array['name'])) {
            throw new NormalizerException(sprintf("Form %s has an invalid name: %s.", $resource, $array['name']));
        }
        $object->setName($array['name']);

        $type = $this->get('geny.provider')->getType($array['type']);


    }
}