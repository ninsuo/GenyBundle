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

    public function getOptionsView()
    {
        return null;
    }

    public function getConstraintsView()
    {
        return null;
    }
}
