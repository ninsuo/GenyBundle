<?php

namespace Fuz\GenyBundle\Data\Resources;

use Fuz\GenyBundle\Data\Validator;
use Symfony\Component\Form\FormInterface;

interface ResourceInterface
{
    const STATE_PENDING    = 'pending';
    const STATE_INPROGRESS = 'in progress';
    const STATE_DONE       = 'done';
    const STATE_FAILED     = 'failed';

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return string
     */
    public function getLoader();

    /**
     * @return string
     */
    public function getFormat();

    /**
     * @return bool
     */
    public function isRoot();

    /**
     * @return string
     */
    public function getState();

    /**
     * @param string $state
     */
    public function setState($state);

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
     * @return FormInterface|TypeInterface
     */
    public function getNormalized();

    /**
     * @param FormInterface|TypeInterface $object
     */
    public function setNormalized($object);

    /**
     * @return Validator
     */
    public function getValidator();

    /**
     * @param Validator $validator
     */
    public function setValidator(Validator $validator);

    /**
     * @return FormInterface
     */
    public function getForm();

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form);
}
