<?php

namespace Fuz\GenyBundle\Provider\Validator;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Validator;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;

class TypeValidator extends BaseService implements ValidatorInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Type';

    public function boot(ResourceInterface $resource)
    {
        return new Validator();
    }

    public function validate(ResourceInterface $resource)
    {
        return [];
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'TypeValidator';
    }
}
