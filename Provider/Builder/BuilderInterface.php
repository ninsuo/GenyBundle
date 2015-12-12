<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraint;

interface BuilderInterface
{
    public function getName();
    public function getDescription();

    public function getDataType($name, array $options = null, $data = null);
    public function getDefaultData();

    public function getOptionsType();
    public function getDefaultOptions();

    /**
     * Returns a form builder that should allow a user to configure the
     * constraints he wants to apply to the field..
     *
     * @return FormBuilderInterface
     */
    public function getConstraintsType();

    /**
     * Returns the default constraints for the given field. For a choice list
     * for example, this will be at least a value that takes part of the
     * possible choices.
     *
     * @param mixed $data
     * @return array|Constraint
     */
    public function getDefaultConstraints($data = null);


    /**
     * Converts the constraints data given into an array of constraints
     * that will be compatible with the symfony validator.
     *
     * @param mixed $constraints
     * @return array
     */
    public function normalizeConstraints($constraints);
}
