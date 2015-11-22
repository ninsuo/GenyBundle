<?php

namespace Fuz\GenyBundle\Data;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;

class DataAssociation
{
    protected $resource;
    protected $data;

    public function __construct(ResourceInterface $resource, $data)
    {
        $this->resource = $resource;
        $this->data     = $data;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getData()
    {
        return $this->data;
    }
}
