<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Event\GenyEvent;
use Fuz\GenyBundle\Exception\BuilderException;
use Fuz\GenyBundle\Provider\Builder\BuilderInterface;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;

class Builder extends BaseService
{
    protected $builders = array();

    public function build(ResourceInterface $resource)
    {
        if (!$resource->isRoot()) {
            return null;
        }

        if (is_null($resource->getNormalized())) {
            throw new BuilderException("Resource should be normalized before being built.");
        }

        $event = new GenyEvent($resource);
        $dispatcher = $this->get('event_dispatcher');

        foreach ($this->builders as $builder) {
            if ($builder->supports($resource)) {
                $dispatcher->dispatch('geny.validator.pre_build', $event);
                if (!is_null($type = $builder->build($resource))) {
                    $resource->setType($type);
                }
                $dispatcher->dispatch('geny.validator.post_build', $event);

                return $type;
            }
        }

        throw new BuilderException(sprintf("No builder found for class '%s'.", get_class($resource)));
    }

    public function hasBuilder($name)
    {
        return isset($this->builders[$name]);
    }

    public function getBuilder($name)
    {
        if (!isset($this->builders[$name])) {
            throw new BuilderException("Builder '{$name}' not found.");
        }

        return $this->builders[$name];
    }

    public function addBuilder(BuilderInterface $builder)
    {
        $this->builders[$builder->getName()] = $builder;
    }

    public function removeBuilder($name)
    {
        unset($this->builders[$name]);
    }

    public function setBuilders(array $builders)
    {
        foreach ($builders as $builder) {
            $this->addBuilder($builder);
        }
    }

    public function getBuilders()
    {
        return $this->builders;
    }
}
