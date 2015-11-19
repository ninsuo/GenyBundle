<?php

namespace Fuz\GenyBundle\Provider\Builder;

class OptionBuilder extends FormBuilder implements BuilderInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Option';

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'OptionBuilder';
    }
}
