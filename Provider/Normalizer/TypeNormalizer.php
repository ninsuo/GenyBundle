<?php

namespace Fuz\GenyBundle\Provider\Normalizer;

use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Normalized;
use Fuz\GenyBundle\Data\Resources;

class TypeNormalizer extends BaseNormalizer implements NormalizerInterface
{
    const CLASS_NAME = 'Fuz\GenyBundle\Data\Resources\Type';

    public function normalize(ResourceInterface $resource)
    {
        $type = new Normalized\Type();
        $resource->setNormalized($type);

        $required = ['name'];
        $optional = ['parent', 'compound', 'visibility', 'supports_options', 'supports_validators'];
        $this->validateRequirements($resource, $required, $optional);

        $this->normalizeName($resource);

        $array = $resource->getUnserialized();

        if (isset($array['parent'])) {
            $this->normalizeParent($resource);
        }

        if (isset($array['compound'])) {
            $this->normalizeCompound($resource);
        }

        if (isset($array['visibility'])) {
            $this->normalizeVisibility($resource);
        }

        if (isset($array['supports_options'])) {
            $this->normalizeSupports($resource, 'option');
        }

        if (isset($array['supports_validators'])) {
            $this->normalizeSupports($resource, 'validator');
        }

        return $type;
    }

    public function normalizeParent(Resources\Type $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        try {
            $type = $this->get('geny.provider')->getType($array['parent']);
        } catch (TypeException $ex) {
            throw $this->throwContextException($resource, $ex);
        }

        try {
            $this->get('geny')->prepare($type);
        } catch (BaseException $ex) {
            throw $this->throwContextException($resource, $ex);
        }

        $parent = $type->getNormalized();

        foreach ($parent->getMainOptions() as $element) {
            $object->getMainOptions()->add($element);
        }

        foreach ($parent->getAdvancedOptions() as $element) {
            $object->getAdvancedOptions()->add($element);
        }

        foreach ($parent->getMainValidators() as $element) {
            $object->getMainValidators()->add($element);
        }

        foreach ($parent->getAdvancedValidators() as $element) {
            $object->getAdvancedValidators()->add($element);
        }

        $object->setVisibility($parent->getVisibility());
        $object->setCompound($parent->isCompound());
    }

    public function normalizeCompound(Resources\Type $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!in_array(strtolower($array['compound']), [
            Normalized\TypeInterface::COMPOUND_FALSE,
            Normalized\TypeInterface::COMPOUND_TRUE])) {
            throw new NormalizerException(sprintf(
                "Compound key in type '%s' takes only '%s' or '%s' values, but %s given.",
                $resource,
                Normalized\TypeInterface::COMPOUND_FALSE,
                Normalized\TypeInterface::COMPOUND_TRUE,
                $array['compound']
            ));
        }

        $object->setCompound(Normalized\TypeInterface::COMPOUND_TRUE === strtolower($array['compound']));
    }

    public function normalizeVisibility(Resources\Type $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!in_array(strtolower($array['visibility']), [
            Normalized\TypeInterface::VISIBILITY_PRIVATE,
            Normalized\TypeInterface::VISIBILITY_PUBLIC])) {
            throw new NormalizerException(sprintf(
                "Visibility key in type '%s' takes only '%s' or '%s' values, but %s given.",
                $resource,
                Normalized\Type::VISIBILITY_PRIVATE,
                Normalized\Type::VISIBILITY_PUBLIC,
                $array['visibility']
            ));
        }

        $object->setVisibility($array['visibility']);
    }

    public function normalizeSupports(Resources\Type $resource, $name)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        $required = ['main', 'advanced'];
        $optional = [];
        $this->validateRequirements($resource, $required, $optional, ["supports_{$name}s"]);

        foreach ($required as $key) {
            foreach ($array["supports_{$name}s"][$key] as $elemName) {
                try {
                    $elem = call_user_func([$this->get('geny.provider'), 'get'.ucfirst($name)], $elemName);
                } catch (OptionException $ex) {
                    throw $this->throwContextException($resource, $ex);
                }
                call_user_func([$object, 'get'.ucfirst($key).ucfirst($name).'s'])->add($elem);
            }
        }
    }

    public function supports($object)
    {
        return self::CLASS_NAME === get_class($object);
    }

    public function getName()
    {
        return 'TypeNormalizer';
    }
}
