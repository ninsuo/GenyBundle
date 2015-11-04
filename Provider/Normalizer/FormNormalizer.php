<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

class FormNormalizer extends BaseFormNormalizer implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Form';

    public function normalize($resource)
    {
        return $this->normalizeForm($resource);
    }

    public function supports($class)
    {
        return self::CLASS_NAME === $class;
    }

    public function getName()
    {
        return 'Form';
    }
}