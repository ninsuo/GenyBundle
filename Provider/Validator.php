<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Event\GenyEvent;
use Fuz\GenyBundle\Exception\ValidatorException;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Provider\Validator\ValidatorInterface;

class Validator extends BaseService
{
    protected $validators = array();

    public function boot(ResourceInterface $resource)
    {
        $event      = new GenyEvent($resource);
        $dispatcher = $this->get('event_dispatcher');

        if (is_null($resource->getNormalized())) {
            throw new ValidatorException("Resource should be normalized before being validated.");
        }

        foreach ($this->validators as $validator) {
            if ($validator->supports($resource)) {
                $dispatcher->dispatch('geny.validator.pre_boot', $event);
                $constraints = $validator->boot($resource);
                $resource->setValidator($constraints);
                $dispatcher->dispatch('geny.validator.post_boot', $event);

                return $constraints;
            }
        }

        throw new ValidatorException(sprintf("No validator found for class '%s'.", get_class($resource)));
    }

    public function validate(ResourceInterface $resource)
    {
        $event      = new GenyEvent($resource);
        $dispatcher = $this->get('event_dispatcher');

//        if (is_null($resource->getType())) {
//            throw new ValidatorException("Type should be built before being validated.");
//        }
//
        if (is_null($resource->getValidator())) {
            $this->boot($resource);
        }

        foreach ($this->validators as $validator) {
            if ($validator->supports($resource)) {
                $dispatcher->dispatch('geny.validator.pre_validate', $event);
                $violations = $validator->validate($resource);
                $dispatcher->dispatch('geny.validator.post_validate', $event);

                return $violations;
            }
        }

        throw new ValidatorException(sprintf("No validator found for class '%s'.", get_class($resource)));
    }

    public function hasValidator($name)
    {
        return isset($this->validators[$name]);
    }

    public function getValidator($name)
    {
        if (!isset($this->validators[$name])) {
            throw new ValidatorException("Validator '{$name}' not found.");
        }

        return $this->validators[$name];
    }

    public function addValidator(ValidatorInterface $validator)
    {
        $this->validators[$validator->getName()] = $validator;
    }

    public function removeValidator($name)
    {
        unset($this->validators[$name]);
    }

    public function setValidators(array $validators)
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
    }

    public function getValidators()
    {
        return $this->validators;
    }

}
