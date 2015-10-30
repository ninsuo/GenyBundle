<?php

namespace Fuz\GenyBundle\Unserializer;

interface UnserializerInterface
{
    public function unserialize($contents);
    public function supports($format);
    public function getName();
}
