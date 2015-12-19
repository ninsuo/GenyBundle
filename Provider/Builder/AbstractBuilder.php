<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Base\BaseService;
use GenyBundle\Entity\Field;
use GenyBundle\Traits\ConstraintsTrait;
use GenyBundle\Traits\FormTrait;
use GenyBundle\Traits\OptionsTrait;
use Symfony\Component\Form\Extension\Core\Type;

abstract class AbstractBuilder extends BaseService implements BuilderInterface
{
    use FormTrait;
    use ConstraintsTrait;
    use OptionsTrait;

    public function normalizeOptions($options)
    {
        return $options;
    }

    public function normalizeConstraints($constraints)
    {
        return $constraints;
    }

    protected function getTypeBuilder($name, $type, array $options = null, $data = null)
    {
        return $this->getBuilder($name, $type, $options ?: $this->getDefaultOptions(), $data ?: $this->getDefaultData());
    }

    protected function getConstraintsBuilder()
    {
        return $this->getBuilder('constraints', Type\FormType::class, $this->getDefaultConstraints());
    }
}
