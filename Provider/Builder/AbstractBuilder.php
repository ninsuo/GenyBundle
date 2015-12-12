<?php

namespace GenyBundle\Provider\Builder;

use GenyBundle\Base\BaseService;
use GenyBundle\Entity\Field;
use GenyBundle\Traits\ConstraintsTrait;
use GenyBundle\Traits\OptionsTrait;
use Symfony\Component\Form\Extension\Core\Type;

abstract class AbstractBuilder extends BaseService implements BuilderInterface
{
    use ConstraintsTrait;
    use OptionsTrait;

    protected function getBuilder($name, $type, array $options = null, $data = null)
    {
        return $this->get('form.factory')->createNamedBuilder($name, $type, [$name => $data], $options);
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
