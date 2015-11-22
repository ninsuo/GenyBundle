<?php

namespace Fuz\GenyBundle\Provider\Extension;

interface ExtensionInterface
{
    public function getForms();
    public function getTypes();
    public function getOptions();
    public function getValidators();
    public function getPriority();
    public function getName();
}