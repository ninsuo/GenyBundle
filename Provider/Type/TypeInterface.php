<?php

namespace GenyBundle\Provider\Type;

interface TypeInterface
{
    public function getName();
    public function getDescription();

    public function getDataType();
    public function getDefaultData();

    public function getOptionsType();
    public function getDefaultOptions();

    public function getConstraintsType();
    public function getDefaultConstraints();
}
