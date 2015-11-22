<?php

namespace Fuz\GenyBundle\Provider\Builder;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\DataAssociation;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;

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

        return $root->getForm();
    }

    protected function createBuilder(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $factory = $this->get('form.factory');

        $options = array_map(function(DataAssociation $option) {
            return [
                $option->getResource()->getNormalized()->getName() => $option->getData()
            ];
        }, $object->getOptions()->toArray());

        $registry = $this->get('form.registry');
        $type     = $object->getType()->getNormalized()->getName();
        if ($registry->hasType("geny_{$type}")) {
            $type = "geny_{$type}";
        }

        return $factory->createNamedBuilder(
            $object->getName(),
            $type,
            null,
            $options ? call_user_func_array('array_merge', $options) : []
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
