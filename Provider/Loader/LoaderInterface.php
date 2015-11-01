<?php

namespace Fuz\GenyBundle\Provider\Loader;

interface LoaderInterface
{
    public function load($resource);
    public function supports($type);
    public function getName();
}