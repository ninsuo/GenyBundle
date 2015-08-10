<?php

namespace Fuz\GenyBundle\Services;

use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Serializer\SerializerInterface;

class Environment
{
    protected $locator;
    protected $serializer;
    protected $types;

    public function __construct(FileLocator $locator, SerializerInterface $serializer)
    {
        $this->locator    = $locator;
        $this->serializer = $serializer;
        $this->types      = array();
    }

    public function load($path)
    {
        if (array_key_exists($path, $this->types)) {
            return $this->types[$path];
        }

        $realpath  = $this->locator->locate($path);
        $contents  = file_get_contents($realpath);
        $extension = strtolower(pathinfo($realpath, PATHINFO_EXTENSION));

        $array = $this->serializer->deserialize($contents, null, $extension);
        \Symfony\Component\VarDumper\VarDumper::dump($array);

        /*
         * 1- Loader (fs, db, ...)
         * 2- Unserializer (json, xml, ...)
         * 3- Validator (geny format is valid?)
         * 4- Form builder
         * 5- Form validator
         */
    }

}
