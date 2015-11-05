<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;

interface NormalizerInterface
{
    public function normalize(ResourceInterface $resource);
    public function supports($class);
    public function getName();
}
