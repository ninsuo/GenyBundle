<?php

namespace Fuz\GenyBundle\Data\Resources;

use Fuz\GenyBundle\Data\Normalized\NormalizedInterface;
use Fuz\GenyBundle\Data\Constraints;

interface ResourceInterface
{
    const STATE_PENDING    = 'pending';
    const STATE_INPROGRESS = 'in progress';
    const STATE_DONE       = 'done';
    const STATE_FAILED     = 'failed';

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
     * @return NormalizedInterface
     */
    public function getNormalized();

    /**
     * @param NormalizedInterface $object
     */
    public function setNormalized(NormalizedInterface $object);

    /**
     * @return string
     */
    public function getState();

    /**
     * @param string $state
     */
    public function setState($state);

    /**
     * @return Constraints
     */
    public function getValidator();

    /**
     * @param Constraints $validator
     */
    public function setValidator(Constraints $validator);
}
