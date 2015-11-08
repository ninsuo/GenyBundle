<?php

namespace Fuz\GenyBundle\Provider\Validator;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Constraints;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\ValidatorException;

class FormValidator extends BaseService implements ValidatorInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Form';

    public function boot(ResourceInterface $resource)
    {
        $this->validateCompound($resource);

        $constraints = new Constraints();

        return $constraints;
    }

    public function validate(ResourceInterface $resource)
    {

    }

    protected function validateCompound(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $array  = $resource->getUnserialized();

        if (isset($array['fields']) && $object->getType() && !$object->getType()->getNormalized()->isCompound()) {
            throw new ValidatorException(sprintf("The 'fields' key should only be used on compound types, '%s' uses it on type '%s'.", $resource, $object->getType()->getNormalized()->getName()));
        }
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'FormValidator';
    }
}
