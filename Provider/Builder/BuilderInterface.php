<?php

namespace Fuz\GenyBundle\Provider\Builder;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;

interface BuilderInterface
{
    public function build(ResourceInterface $resource);
    public function supports($object);
    public function getName();
}

