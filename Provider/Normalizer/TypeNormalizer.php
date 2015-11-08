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
        $optional = ['parent', 'compound', 'supports_options', 'supports_validators'];
        $this->validateRequirements($resource, $required, $optional);

        $this->normalizeName($resource);

        $array = $resource->getUnserialized();

        if (isset($array['parent'])) {
            $this->normalizeParent($resource);
        }

        if (isset($array['compound'])) {
            $this->normalizeCompound($resource);
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

        try
        {
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

        foreach ($parent->getSpecialOptions() as $element) {
            $object->getSpecialOptions()->add($element);
        }

        foreach ($parent->getMainValidators() as $element) {
            $object->getMainValidators()->add($element);
        }

        foreach ($parent->getAdvancedValidators() as $element) {
            $object->getAdvancedValidators()->add($element);
        }

        foreach ($parent->getSpecialValidators() as $element) {
            $object->getSpecialValidators()->add($element);
        }

        $object->setVisibility($parent->getVisibility());
        $object->setCompound($parent->isCompound());
    }

    public function normalizeCompound(Resources\Type $resource)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        if (!in_array(strtolower($array['compound']), array('false', 'true'))) {
            throw new NormalizerException(sprintf("Compound key in type '%s' takes only 'true' or 'false' value: %s given.", $resource, $array['compound']));
        }

        $object->setCompound(strtolower($array['compound']) === 'true');
    }

    public function normalizeSupports(Resources\Type $resource, $name)
    {
        $object = $resource->getNormalized();
        $array = $resource->getUnserialized();

        $required = ['main', 'advanced', 'special'];
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