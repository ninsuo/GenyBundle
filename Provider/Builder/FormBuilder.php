<?php

namespace Fuz\GenyBundle\Provider\Builder;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Resources\Option;
use Fuz\GenyBundle\Exception\BuilderException;

class FormBuilder extends BaseService implements BuilderInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Form';

    public function build(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $factory = $this->get('form.factory');

        if ($object->getType()->getNormalized()->isCompound()) {
            $root = $this->createBuilder($resource);
            foreach ($object->getFields() as $field) {
                $root->add($this->createBuilder($field));
            }
        } else {
            $root = $factory->createNamedBuilder('root');
            $root->add($this->createBuilder($resource));
        }
    }

    protected function createBuilder(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $factory = $this->get('form.factory');

        return $factory->createNamedBuilder(
            $object->getName(),
            $object->getType()->getNormalized()->getName(),
            null,
            array_merge(
                array_map(function(Option $option) {
                    return [
                       $option->getNormalized()->getName() => $option->getNormalized()->getData()
                    ];
                }, $object->getOptions()->toArray())
            )
        );
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'FormBuilder';
    }
}
