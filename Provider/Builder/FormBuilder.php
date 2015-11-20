<?php

namespace Fuz\GenyBundle\Provider\Builder;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\BuilderException;

class FormBuilder extends BaseService implements BuilderInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Form';

    public function build(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();

        if ($object->getType()->getNormalized()->isCompound()) {
            $root = $this->get('form.factory')->createNamedBuilder(
               $object->getName(),
               $form->getType()->getName(),
               null,
               $form->getOptions()
            );
            foreach ($form->getFields() as $field) {
                $root->add($this->createBuilder($field));
            }
        } else {

        }

        // @form.factory

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
