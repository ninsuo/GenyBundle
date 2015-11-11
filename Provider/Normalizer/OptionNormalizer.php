<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Normalized\Option;

class OptionNormalizer extends BaseFormNormalizer implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Option';

    public function normalize(ResourceInterface $resource)
    {
        $option = new Option();
        $resource->setNormalized($option);

        return $this->normalizeForm($resource);
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'OptionNormalizer';
    }
}