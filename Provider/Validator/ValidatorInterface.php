<?php

namespace Fuz\GenyBundle\Provider\Validator;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;

interface ValidatorInterface
{
    public function boot(ResourceInterface $resource);
    public function validate(ResourceInterface $resource);
    public function supports($object);
    public function getName();
}
