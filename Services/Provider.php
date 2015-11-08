<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Exception\TypeException;
use Fuz\GenyBundle\Exception\OptionException;
use Fuz\GenyBundle\Exception\ValidatorException;

class Provider extends BaseService
{
    public function getType($name) {
        foreach ($this->get('geny.extension')->getExtensions() as $extension) {
            $types = $extension->getTypes();
            if (array_key_exists($name, $types)) {
                return $types[$name];
            }
        }

        throw new TypeException("Type '{$name}' not found.");
    }

    public function getOption($name) {
        foreach ($this->get('geny.extension')->getExtensions() as $extension) {
            $options = $extension->getOptions();
            if (array_key_exists($name, $options)) {
                return $options[$name];
            }
        }

        throw new OptionException("Option '{$name}' not found.");
    }

    public function getValidator($name) {
        foreach ($this->get('geny.extension')->getExtensions() as $extension) {
            $validators = $extension->getValidators();
            if (array_key_exists($name, $validators)) {
                return $validators[$name];
            }
        }

        throw new ValidatorException("Validator '{$name}' not found.");
    }
}