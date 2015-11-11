<?php

namespace Fuz\GenyBundle\Data\Normalized;

interface FormInterface
{
    public function getResource();
    public function getName();
    public function getType();
    public function getOptions();
    public function getValidators();
    public function getFields();
    public function getData();
    public function setData($data);
}
