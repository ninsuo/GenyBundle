<?php

namespace Fuz\GenyBundle\Services;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Fuz\GenyBundle\Entity\Form;
use Fuz\GenyBundle\Exception\BuilderException;

class Builder
{
    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function build(Form $form)
    {
        if ('form' === $form->getType()->getName()) {
            $root = $this->formFactory->createNamedBuilder($form->getName(), $form->getType()->getName(), null, $form->getOptions()->toArray());
            foreach ($form->getFields() as $field) {
                $root->add($this->createBuilder($field));
            }
        } else {
            $root = $this->formFactory->createNamedBuilder('root');
            $root->add($this->createBuilder($form));
        }
        return $root->getForm();
    }

    public function createBuilder(Form $form)
    {
        switch ($form->getType()->getName()) {
            case 'form':
            case 'container':
                $builder = $this->createContainerBuilder($form);
                break;
            case 'collection':
                $builder = $this->createCollectionBuilder($form);
                break;
            default:
                $builder = $this->formFactory->createNamedBuilder($form->getName(), $form->getType()->getName(), null, $form->getOptions()->toArray());
                break;
        }
        return $builder;
    }

    public function createContainerBuilder(Form $form)
    {
        $builder = $this->formFactory->createNamedBuilder($form->getName(), 'container', null, $form->getOptions()->toArray());
        foreach ($form->getFields() as $field) {
            $builder->add($this->createBuilder($field));
        }
        return $builder;
    }

    public function createCollectionBuilder(Form $form)
    {
        if ($form->getFields()->count() === 0) {
            throw new BuilderException(sprintf("Collection %s is empty.", $form->getResource()));
        } else if ($form->getFields()->count() === 1) {
            $options = array_merge($form->getOptions()->toArray(), array(
                'type' => $this->createBuilder($form->getFields()->first())->getType()
            ));
            return $this->formFactory->createNamedBuilder($form->getName(), 'collection', null, $options);
        } else {
            $builder = $this->formFactory->createNamedBuilder('fields', 'container');
            foreach ($form->getFields() as $field) {
                $builder->add($this->createBuilder($field));
            }
            return $this->formFactory->createNamedBuilder($form->getName(), 'collection', null, array_merge($form->getOptions()->toArray(), array(
                   'type' => $builder->getType()
            )));
        }
    }

}
