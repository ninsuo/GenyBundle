<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Event\GenyEvent;
use Fuz\GenyBundle\Exception\NormalizerException;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Provider\Normalizer\NormalizerInterface;

class Normalizer extends BaseService
{
    protected $normalizers = array();

    public function normalize(ResourceInterface $resource)
    {
        if ($resource->isRoot() && is_null($resource->getUnserialized())) {
            throw new NormalizerException("Resource should be unserialized before being normalized.");
        }

        if (!is_null($resource->getNormalized())) {
            return $resource->getNormalized();
        }

        $event = new GenyEvent($resource);
        $dispatcher = $this->get('event_dispatcher');

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($resource)) {
                $dispatcher->dispatch('geny.validator.pre_normalize', $event);
                $normalized = $normalizer->normalize($resource);
                $resource->setNormalized($normalized);
                $dispatcher->dispatch('geny.validator.post_normalize', $event);

                return $normalized;
            }
        }

        throw new NormalizerException(sprintf("No normalizer found for class '%s'.", get_class($resource)));
    }

    public function hasNormalizer($name)
    {
        return isset($this->normalizers[$name]);
    }

    public function getNormalizer($name)
    {
        if (!isset($this->normalizers[$name])) {
            throw new NormalizerException("Normalizer '{$name}' not found.");
        }

        return $this->normalizers[$name];
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[$normalizer->getName()] = $normalizer;
    }

    public function removeNormalizer($name)
    {
        unset($this->normalizers[$name]);
    }

    public function setNormalizers(array $normalizers)
    {
        foreach ($normalizers as $normalizer) {
            $this->addNormalizer($normalizer);
        }
    }

    public function getNormalizers()
    {
        return $this->normalizers;
    }
}
