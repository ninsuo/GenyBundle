<?php

namespace Fuz\GenyBundle\Data\Resources;

interface ResourceInterface
{
    public function getLoader();
    public function getResource();
    public function getFormat();

    public function getLoaded();
    public function setLoaded($contents);

    public function getUnserialized();
    public function setUnserialized(array $array);

    public function getNormalized();
    public function setNormalized($object);
}
