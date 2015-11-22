<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Normalized\Validator;

class ValidatorNormalizer extends BaseFormNormalizer implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Validator';

    public function normalize(ResourceInterface $resource)
    {
        $validator = new Validator();
        $resource->setNormalized($validator);

        return $this->normalizeForm($resource);
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'ValidatorNormalizer';
    }
}
