<?php

namespace Fuz\GenyBundle\Provider\Validator;

class OptionValidator extends FormValidator implements ValidatorInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Option';

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'OptionValidator';
    }
}