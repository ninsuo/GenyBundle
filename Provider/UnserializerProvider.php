<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Provider\Unserializer\UnserializerInterface;
use Fuz\GenyBundle\Exception\UnserializerException;

class UnserializerProvider extends BaseService
{
    protected $unserializers = array();

    public function unserialize($type, $contents)
    {
        foreach ($this->unserializers as $unserializer) {
            if ($unserializer->supports($type)) {
                return $unserializer->unserialize($contents);
            }
        }

        throw new UnserializerException(sprintf("Unserializer %s is not implemented.", $type));
    }

    public function addUnserializer(UnserializerInterface $unserializer)
    {
        $this->unserializers[] = $unserializer;
    }
}
