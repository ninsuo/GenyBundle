<?php

namespace Fuz\GenyBundle\Provider\Validator;

class ValidatorValidator extends FormValidator implements ValidatorInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Validator';

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'ValidatorValidator';
    }
}
