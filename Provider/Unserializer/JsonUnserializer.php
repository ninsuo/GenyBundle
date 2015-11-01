<?php

namespace Fuz\GenyBundle\Provider\Unserializer;

class JsonUnserializer implements UnserializerInterface
{
    const FORMAT_JSON = 'json';

    public function unserialize($contents)
    {
        $data = json_decode($contents, true);
        if (false === $data) {
            throw new UnserializerException(sprintf("Unable to unserialize '%s': %s", $contents, json_last_error_msg()));
        }

        return $data;
    }

    public function supports($format)
    {
        return self::FORMAT_JSON === strtolower($format);
    }

    public function getName()
    {
        return self::FORMAT_JSON;
    }
}
