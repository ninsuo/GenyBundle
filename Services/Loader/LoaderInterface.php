<?php

namespace Fuz\GenyBundle\Services\Loader;

interface LoaderInterface
{
    public function load($resource);
    public function supports($type);
}