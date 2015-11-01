<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

interface NormalizerInterface
{
    public function normalize($resource);
    public function supports($class);
    public function getName();
}
