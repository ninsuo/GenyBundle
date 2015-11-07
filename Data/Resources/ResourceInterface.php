<?php

namespace Fuz\GenyBundle\Data\Resources;

interface ResourceInterface
{
    /**
     * @return string
     */
    public function getLoader();

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return string
     */
    public function getFormat();

    /**
     * @return string
     */
    public function getLoaded();

    /**
     * @param string $contents
     */
    public function setLoaded($contents);

    /**
     * @return array
     */
    public function getUnserialized();

    /**
     * @param array $array
     */
    public function setUnserialized(array $array);

    /**
     * @return ResourceInterface
     */
    public function getNormalized();

    /**
     * @param ResourceInterface $object
     */
    public function setNormalized($object);
}
