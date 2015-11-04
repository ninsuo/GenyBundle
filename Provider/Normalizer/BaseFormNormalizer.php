<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;

abstract class BaseFormNormalizer extends BaseNormalizer implements NormalizerInterface
{
    public function normalizeForm(ResourceInterface $resource)
    {
        $required = ['name', 'type'];
        $optional = ['options', 'validation', 'fields', 'data'];
        $this->validateConstraints($resource, $required, $optional);


    }
}