<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\NormalizerException;

abstract class BaseFormNormalizer extends BaseNormalizer implements NormalizerInterface
{
    public function normalizeForm(ResourceInterface $resource)
    {
        $required = ['name', 'type'];
        $optional = ['options', 'validation', 'fields', 'data'];
        $this->validateRequirements($resource, $required, $optional);

        $data = $resource->getUnserialized();

        if (!preg_match("/^[0-9a-zA-Z_]+$/", $data['name'])) {
            throw new NormalizerException(sprintf("Form %s has an invalid name: %s.", $resource, $data['name']));
        }



    }
}