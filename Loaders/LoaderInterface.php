<?php

namespace Fuz\GenyBundle\Loader;

interface LoaderInterface
{
    public function load($resource);
    public function supports($type);
    public function getName();
}