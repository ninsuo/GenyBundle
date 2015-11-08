<?php

namespace Fuz\GenyBundle\Provider;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Exception\ValidatorException;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Provider\Validator\ValidatorInterface;

class Validator extends BaseService
{
    protected $validators = array();

    public function boot(ResourceInterface $resource)
    {
        if (is_null($resource->getNormalized())) {
            throw new ValidatorException("Resource should be normalized before being validated.");
        }

        foreach ($this->validators as $validator) {
            if ($validator->supports($resource)) {
                $constraints = $validator->boot($resource);
                $resource->setValidator($constraints);

                return $constraints;
            }
        }

        throw new ValidatorException(sprintf("No validator found for class '%s'.", get_class($resource)));
    }

    public function validate(ResourceInterface $resource)
    {
        if (is_null($resource->getNormalized())) {
            throw new ValidatorException("Resource should be normalized before being validated.");
        }

        foreach ($this->validators as $validator) {
            if ($validator->supports($resource)) {

                // ...

                return $validator->validate($resource);
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
