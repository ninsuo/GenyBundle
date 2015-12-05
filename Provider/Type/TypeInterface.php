<?php

namespace GenyBundle\Provider\Type;

interface TypeInterface
{
    public function getOptionsType();
    public function getDefaultOptions();

    public function getConstraintsType();
    public function getDefaultConstraints();

    public function getName();
    public function getTypeClass();
    public function getDescription();

    public function isInternal();
}
