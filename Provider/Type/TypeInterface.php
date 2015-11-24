<?php

namespace GenyBundle\Provider\Type;

interface TypeInterface
{
    public function getOptionsType();
    public function getOptionsData();
    public function getConstraintsType();
    public function getConstraintsData();
    public function getName();
}

