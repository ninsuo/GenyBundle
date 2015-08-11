<?php

namespace Fuz\GenyBundle\Services;

use Symfony\Component\Form\FormFactoryInterface;
use Fuz\GenyBundle\Entity\Form;

class Builder
{

    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function build(Form $form)
    {
        return $this->buildForm($form)->getForm();
    }

    public function buildForm(Form $form)
    {
        if ($form->getFields()->count() > 0) {
            $builder = $this->formFactory->createNamedBuilder($form->getName(), $form->getType()->getName(), null, $form->getOptions()->toArray());
            $form->getFields()->forAll(function($index, Form $field) use ($builder) {
                return $builder->add($this->buildForm($field));
            });
            return $builder;
        }
        return $this->formFactory->createNamedBuilder($form->getName(), $form->getType()->getName(), null, $form->getOptions()->toArray());
    }

}