<?php

namespace Fuz\GenyBundle\Provider\Unserializer;

interface UnserializerInterface
{
    public function unserialize($contents);
    public function supports($type);
}
