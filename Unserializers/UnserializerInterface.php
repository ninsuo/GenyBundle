<?php

namespace Fuz\GenyBundle\Unserializer;

interface UnserializerInterface
{
    public function unserialize($contents);
    public function supports($type);
    public function getName();
}
