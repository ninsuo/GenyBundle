<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Normalized\Form;

class FormNormalizer extends BaseFormNormalizer implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Form';

    public function normalize(ResourceInterface $resource)
    {
        $resource->setNormalized(new Form());

        return $this->normalizeForm($resource);
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'FormNormalizer';
    }
}
