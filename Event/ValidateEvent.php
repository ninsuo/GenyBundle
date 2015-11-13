<?php

namespace Fuz\GenyBundle\Event;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Symfony\Component\EventDispatcher\Event;

class GenyEvent extends Event
{
    protected $resource;

    public function __construct(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }
}
