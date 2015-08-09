<?php

namespace Fuz\GenyBundle\Services;

class Environment
{

    protected $types;

    public function __construct()
    {
        $this->types = array();
    }

    public function load($path)
    {
        if (array_key_exists($path, $this->types)) {
            return $this->types[$path];
        }


        /*
         * 1- Loader (fs, db, ...)
         * 2- Unserializer (json, xml, ...)
         * 3- Validator (geny format is valid?)
         * 4- Form builder
         * 5- Form validator
         */

    }


}
