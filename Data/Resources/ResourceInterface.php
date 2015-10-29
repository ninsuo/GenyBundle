<?php

namespace Fuz\GenyBundle\Data\Resources;

interface ResourceInterface
{
    public function getLoader();

    public function getResource();

    public function getFormat();

    public function getContents();
}
