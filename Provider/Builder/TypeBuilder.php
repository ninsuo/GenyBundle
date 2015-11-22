<?php

namespace Fuz\GenyBundle\Provider\Builder;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;

class TypeBuilder extends BaseService implements BuilderInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Type';

    public function build(ResourceInterface $resource)
    {
        return;
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'TypeBuilder';
    }
}
