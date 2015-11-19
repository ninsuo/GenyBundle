<?php

namespace Fuz\GenyBundle\Provider\Builder;

class ValidatorBuilder extends FormBuilder implements BuilderInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Validator';

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'ValidatorBuilder';
    }
}
