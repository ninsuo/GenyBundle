<?php

namespace Fuz\GenyBundle\Services;

use Symfony\Component\Form\FormInterface;
use Fuz\GenyBundle\Entity\Form;

class Initializer
{

    public function initialize(FormInterface $type, Form $form, $scope = 0)
    {
        if (false === $form->getType()->isCompound()) {

            // todo if scope == 0, use $type->get($form->getName()) instead of $type


            if (is_null($form->getData())) {
                return;
            }
            $type->setData($form->getData());
            return;
        }

        foreach ($form->getFields() as $field) {
            $child = $type->get($field->getName());
            $this->initialize($child, $field, $scope + 1);
        }
    }

}
