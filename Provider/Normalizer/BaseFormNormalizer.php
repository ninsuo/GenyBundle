<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Resources\Form;
use Fuz\GenyBundle\Exception\NormalizerException;
use Fuz\GenyBundle\Exception\BaseException;
use Fuz\GenyBundle\Exception\OptionException;
use Fuz\GenyBundle\Exception\TypeException;
use Fuz\GenyBundle\Exception\ValidatorException;

abstract class BaseFormNormalizer extends BaseNormalizer implements NormalizerInterface
{
    public function normalizeForm(ResourceInterface $resource)
    {
        if (is_null($object = $resource->getNormalized())) {
            throw new NormalizerException("An empty normalized object should be created before normalizing data.");
        }

        $required = ['name', 'type'];
        $optional = ['options', 'validation', 'fields', 'data'];
        $this->validateRequirements($resource, $required, $optional);

        $this->normalizeName($resource);
        $this->normalizeType($resource);

        $array = $resource->getUnserialized();

        if (isset($array['options'])) {
            $this->normalizeOptions($resource);
        }

        if (isset($array['validation'])) {
            $this->normalizeValidators($resource);
        }

        if (isset($array['fields'])) {
            $this->normalizeFields($resource);
        }

        if (isset($array['data'])) {
            $resource->getNormalized()->setData($array['data']);
        }

        return $object;
    }

    public function normalizeType(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        try {
            $type = $this->get('geny.provider')->getType($array['type']);
        } catch (TypeException $ex) {
            throw new NormalizerException(sprintf("'%s' > %s", $resource,  $ex->getMessage()));
        }

        try
        {
            $this->get('geny')->prepare($type);
        } catch (BaseException $ex) {
            throw $this->throwContextException($resource, $ex);
        }

        $object->setType($type);
    }

    public function normalizeOptions(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!is_array($array['options'])) {
            throw new NormalizerException(sprintf("The 'options' key should contain an array of options in '%s', '%s' given.", $resource, gettype($array['options'])));
        }

        $options = $object->getOptions();
        foreach ($array['options'] as $optionName => $data) {
            try {
                $option = $this->get('geny.provider')->getOption($optionName);
            } catch (OptionException $ex) {
                throw new NormalizerException(sprintf("'%s' > %s", $resource,  $ex->getMessage()));
            }

            try
            {
                $this->get('geny')->prepare($option);
            } catch (BaseException $ex) {
                throw $this->throwContextException($resource, $ex);
            }

            $option->getNormalized()->setData($data);
            $options->add($option);
        }
    }

    public function normalizeValidators(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!is_array($array['validators'])) {
            throw new NormalizerException(sprintf("The 'validation' key should contain an array of validators in '%s', '%s' given.", $resource, gettype($array['validators'])));
        }

        $validators = $object->getValidators();
        foreach ($array['validators'] as $validatorName => $data) {
            try {
                $validator = $this->get('geny.provider')->getValidator($validatorName);
            } catch (ValidatorException $ex) {
                throw new NormalizerException(sprintf("'%s' > %s", $resource,  $ex->getMessage()));
            }

            try
            {
                $this->get('geny')->prepare($validator);
            } catch (BaseException $ex) {
                throw $this->throwContextException($resource, $ex);
            }

            $validator->getNormalized()->setData($data);
            $validators->add($validator);
        }
    }

    public function normalizeFields(ResourceInterface $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!is_array($array['fields'])) {
            throw new NormalizerException(sprintf("The 'fields' key should contain an array of fields in '%s', '%s' given.", $resource, gettype($array['fields'])));
        }

        $fields = $object->getFields();
        foreach ($array['fields'] as $fieldName => $fieldContent) {
            $form = new Form($resource->getLoader(), $fieldName, $resource->getFormat(), false);
            $form->setUnserialized(array_merge(['name' => $fieldName], $fieldContent));

            try
            {
                $this->get('geny')->prepare($form);
            } catch (BaseException $ex) {
                throw $this->throwContextException($resource, $ex);
            }

            $fields->add($form);
        }
    }
}