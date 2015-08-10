<?php

namespace Fuz\GenyBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Fuz\GenyBundle\Services\Builder;

class ContainerType extends FormType
{

    protected $fields;

    public function __construct(Builder $builder, array $fields)
    {
        parent::__construct();
        $this->fields = $fields;
    }


    

    public function getName()
    {
        return 'container';
    }

}