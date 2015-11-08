<?php

namespace Fuz\GenyBundle\Provider\Validator;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;

class OptionValidator extends BaseValidator implements ValidatorInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Option';

    public function validate(ResourceInterface $resource)
    {

    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'OptionValidator';
    }
}
