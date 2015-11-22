<?php

namespace Fuz\GenyBundle\Data\Normalized;

interface TypeInterface
{
    const VISIBILITY_PUBLIC  = 'public';
    const VISIBILITY_PRIVATE = 'private';

    const COMPOUND_TRUE  = "true";
    const COMPOUND_FALSE = "false";

    public function getName();
    public function getMainOptions();
    public function getAdvancedOptions();
    public function getMainValidators();
    public function getAdvancedValidators();
    public function getVisibility();
    public function isCompound();
}
