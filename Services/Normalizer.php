<?php

namespace Fuz\GenyBundle\Services;

use Fuz\GenyBundle\Base\BaseService;
use Fuz\GenyBundle\Data\Resources\ResourceInterface;
use Fuz\GenyBundle\Data\Resources\Form;
use Fuz\GenyBundle\Data\Resources\Option;
use Fuz\GenyBundle\Data\Resources\Type;
use Fuz\GenyBundle\Data\Resources\Validator;
use Fuz\GenyBundle\Exception\NormalizerException;

class Normalizer extends BaseService
{
    protected $stack = array();

    public function normalize(ResourceInterface $resource)
    {
        /*
         * todo:
         * - create geny.normalizer tag and do like other providers
         * - use complete get_class name to allow extending
         *
         */

        if (is_null($resource->getUnserialized())) {
            throw new NormalizerException("Resource should be unserialized before being normalized.");
        }

        if (!is_null($resource->getNormalized())) {
            return $resource->getNormalized();
        }

        $class = get_class($resource);
        switch (substr($class, strrpos($class, '\\') + 1)) {
            case 'Form':
                $normalized = $this->normalizeForm($resource);
                break ;
            case 'Type':
                $normalized = $this->normalizeType($resource);
                break ;
            case 'Option':
                $normalized = $this->normalizeOption($resource);
                break ;
            case 'Validator':
                $normalized = $this->normalizeValidator($resource);
                break ;
            default:
                throw new NormalizerException("Unknown resource type: {$class}");
        }

        return $normalized;
    }

    public function normalizeForm(Form $form)
    {

    }

    public function normalizeType(Type $type)
    {

    }

    public function normalizeOption(Option $option)
    {

    }

    public function normalizeValidator(Validator $validator)
    {

    }
}
