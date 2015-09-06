<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Agent\Agent;
use Fuz\GenyBundle\Entity\Form;
use Fuz\GenyBundle\Entity\Type;
use Fuz\GenyBundle\Exception\NormalizerException;
use Fuz\GenyBundle\Provider\Loader;

class Normalizer
{
    const DIR_OPTIONS       = '@FuzGenyBundle/Resources/geny/options';
    const DIR_TYPES         = '@FuzGenyBundle/Resources/geny/types';
    const DIR_VALIDATORS    = '@FuzGenyBundle/Resources/geny/validators';
    const CORE_LOADER       = Loader\FileLoader::TYPE_FILE;
    const CORE_UNSERIALIZER = Unserializer::FORMAT_JSON;

    protected $agent;
    protected $loader;
    protected $unserializer;
    protected $validator;

    public function __construct(Agent $agent, Loader $loader, Unserializer $unserializer, Validator $validator)
    {
        $this->agent        = $agent;
        $this->loader       = $loader;
        $this->unserializer = $unserializer;
        $this->validator    = $validator;
    }

    public function normalizeForm($resource, array &$data, array $optionsStack = array(), array $validatorsStack = array())
    {
        if ($this->agent->getForms()->containsKey($resource)) {
            return $this->agent->getForms()->get($resource);
        }

        $form = new Form();
        $form->setResource($resource);

        if (!array_key_exists('type', $data)) {
            throw new NormalizerException(sprintf("Form %s has no type.", $resource));
        }

        $form->setType($this->normalizeType($data['type']));

        if (!array_key_exists('name', $data)) {
            throw new NormalizerException(sprintf("Form %s has no name.", $resource));
        }

        if (!preg_match("/^[0-9a-zA-Z_]+$/", $data['name'])) {
            throw new NormalizerException(sprintf("Form %s has an invalid name: %s.", $resource, $data['name']));
        }
        $form->setName($data['name']);

        if (array_key_exists('options', $data)) {
            foreach ($data['options'] as $optionName => $parameters) {
                if (!in_array($optionName, $form->getType()->getSupportsOptions())) {
                    throw new NormalizerException(sprintf("Type %s does not support %s option", $form->getType()->getName(), $optionName));
                }

                if (!in_array($optionName, $optionsStack)) {
                    array_push($optionsStack, $optionName);
                    $this->normalizeOption($optionName, $optionsStack, $validatorsStack);
                    array_pop($optionsStack);
                }

                $this->validator->validate($this->agent->getOptions()->get($optionName), $parameters);
                $form->getOptions()->set($optionName, $parameters);
            }
        }

        if (array_key_exists('validation', $data)) {
            foreach ($data['validation'] as $validatorName => $parameters) {
                if (!in_array($validatorName, $form->getType()->getSupportsValidators())) {
                    throw new NormalizerException(sprintf("Type %s does not support %s validator", $form->getType()->getName(), $validatorName));
                }

                if (!in_array($validatorName, $validatorsStack)) {
                    array_push($validatorsStack, $validatorName);
                    $this->normalizeValidator($validatorName, $optionsStack, $validatorsStack);
                    array_pop($validatorsStack);
                }

                $this->validator->validate($this->agent->getValidators()->get($validatorName), $parameters);
                $form->getValidation()->set($validatorName, $parameters);
            }
        }

        if (array_key_exists('fields', $data)) {

            if (!$form->getType()->isCompound()) {
                throw new NormalizerException(sprintf("Type %s is not compound and can't contain a 'field' attribute.", $form->getType()->getName()));
            }

            foreach ($data['fields'] as $name => $field) {
                if (!array_key_exists('name', $field)) {
                    $field['name'] = $name;
                }
                $subform = $this->normalizeForm("{$resource}[{$name}]", $field, $optionsStack, $validatorsStack);
                $form->getFields()->add($subform);
            }
        }

        if (array_key_exists('data', $data)) {
            $form->setData($data['data']);

            // todo: we should validate those data with the form
        }

        $this->agent->getForms()->set($resource, $form);
        return $form;
    }

    public function normalizeType($typeName, array $parents = array())
    {
        if ($this->agent->getTypes()->containsKey($typeName)) {
            return $this->agent->getTypes()->get($typeName);
        }

        $realpath = self::DIR_TYPES.'/'.$typeName.'.'.self::CORE_UNSERIALIZER;
        $contents = $this->loader->load(self::CORE_LOADER, $realpath);
        $data     = $this->unserializer->unserialize($realpath, self::CORE_UNSERIALIZER, $contents);

        $type = new Type();

        if (!array_key_exists('name', $data)) {
            throw new NormalizerException("Type %s exists, but do not contain the name field.");
        }

        if ($typeName !== $data['name']) {
            throw new NormalizerException("Type %s exists, but doesn't contain a valid name (%s).", $typeName, $data['name']);
        }

        $type->setName($typeName);

        $parents[] = $typeName;

        if (array_key_exists('parent', $data)) {
            if (in_array($data['parent'], $parents)) {
                throw new NormalizerException(sprintf("Parent-child hierarchy loop in %s -> %s", implode(' -> ', $parents), $typeName));
            }

            $parent = $this->normalizeType($data['parent'], $parents);

            $type->setSupportsOptions($parent->getSupportsOptions());
            $type->setSupportsValidators($parent->getSupportsValidators());
            $type->setVisibility($parent->getVisibility());
            $type->setCompound($parent->isCompound());
        }

        if (array_key_exists('supports_options', $data)) {
            $type->setSupportsOptions(array_merge(
                  $type->getSupportsOptions(), $data['supports_options']
            ));
        }

        if (array_key_exists('supports_validators', $data)) {
            $type->setSupportsValidators(array_merge(
                  $type->getSupportsValidators(), $data['supports_validators']
            ));
        }

        if (array_key_exists('visibility', $data)) {
            if (!in_array($data['visibility'], array(
                   Type::VISIBILITY_PRIVATE,
                   Type::VISIBILITY_PUBLIC,
               ))) {
                throw new NormalizerException(sprintf("Unknown visibility given in %s: %s", $typeName, $data['visibility']));
            }

            $type->setVisibility($data['visibility']);
        }

        if (array_key_exists('compound', $data)) {
            if (!in_array($data['compound'], array(
                   Type::COMPOUND_TRUE,
                   Type::COMPOUND_FALSE,
               ))) {
                throw new NormalizerException(sprintf("Unknown compound value given in %s: %s", $typeName, $data['compound']));
            }

            $type->setCompound(Type::COMPOUND_TRUE === strtolower($data['compound']));
        }

        $this->agent->getTypes()->set($typeName, $type);
        return $type;
    }

    public function normalizeOption($optionName, array $optionsStack, array $validatorsStack)
    {
        if ($this->agent->getOptions()->containsKey($optionName)) {
            return $this->agent->getOptions()->get($optionName);
        }

        $realpath = self::DIR_OPTIONS.'/'.$optionName.'.'.self::CORE_UNSERIALIZER;
        $contents = $this->loader->load(self::CORE_LOADER, $realpath);
        $data     = $this->unserializer->unserialize($realpath, self::CORE_UNSERIALIZER, $contents);
        $option   = $this->normalizeForm($realpath, $data, $optionsStack, $validatorsStack);

        $this->agent->getOptions()->set($optionName, $option);
        return $option;
    }

    public function normalizeValidator($validatorName, array $optionsStack, array $validatorsStack)
    {
        if ($this->agent->getValidators()->containsKey($validatorName)) {
            return $this->agent->getValidators()->get($validatorName);
        }

        $realpath = self::DIR_VALIDATORS.'/'.$validatorName.'.'.self::CORE_UNSERIALIZER;
        $contents = $this->loader->load(self::CORE_LOADER, $realpath);
        $data     = $this->unserializer->unserialize($realpath, self::CORE_UNSERIALIZER, $contents);
        $option   = $this->normalizeForm($realpath, $data, $optionsStack, $validatorsStack);

        $this->agent->getValidators()->set($validatorName, $option);
        return $option;
    }

}
