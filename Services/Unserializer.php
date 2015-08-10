<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Exception\UnserializerException;

class Unserializer
{
    const FORMAT_JSON = 'json';

    public function unserialize($resource, $format, $contents)
    {
        switch ($format) {
            case self::FORMAT_JSON:
                $data = json_decode($contents, true);
                if (false === $data) {
                    throw new UnserializerException(sprintf("Unable to unserialize '%s': %s", $resource, json_last_error_msg()));
                }
                break;
            default:
                throw new UnserializerException(sprintf("Unserializer %s is not implemented.", $format));
        }
        return $data;
    }
}
