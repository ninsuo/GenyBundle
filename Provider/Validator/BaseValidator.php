<?php

namespace Fuz\GenyBundle\Provider\Validator;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Exception\ValidatorException;

abstract class BaseFormValidator extends BaseService
{
    public function bootForm(ResourceInterface $resource)
    {
        $this->validateCompound($resource);


        
    }

    public function validateCompound(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();

        if (!$object->getType()->getNormalized()->isCompound()) {
            throw new ValidatorException(sprintf("The 'fields' key should only used on compound types, '%s' uses it on type '%s'.", $resource, $resource->getType()->getNormalized()->getName()));
        }
    }
}
