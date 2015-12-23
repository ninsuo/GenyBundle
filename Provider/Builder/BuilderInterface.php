<?php

namespace GenyBundle\Provider\Builder;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraint;
use GenyBundle\Entity\Field;

interface BuilderInterface
{
    public function getName();
    public function getDescription();

    public function getDataType(Field $entity);
    public function getDefaultData();

    public function getOptionsType(Field $entity, $data);
    public function getOptionsView();

    /**
     * Returns the default options set for this field (except the
     * label, help text and required options); they will be used
     * to fill the "Options" form. If the type doesn't support
     * any option, this method should return null.
     *
     * @return array|null
     */
    public function getDefaultOptions();

    public function normalizeOptions(Field $entity);

    /**
     * Returns a form builder that should allow a user to configure the
     * constraints he wants to apply to the field..
     *
     * @return FormBuilderInterface
     */
    public function getConstraintsType(Field $entity, $data);

    public function getConstraintsView();

    /**
     * Returns the default constraints for the given field. For a choice list
     * for example, this will be at least a value that takes part of the
     * possible choices. If the type doesn't support any constraint, this method
     * should return null.
     *
     * @return array|Constraint|null
     */
    public function getDefaultConstraints();

    /**
     * Converts the constraints data given into an array of constraints
     * that will be compatible with the symfony validator.
     *
     * @param Field $entity
     * @return array
     */
    public function normalizeConstraints(Field $entity);
}
