<?php

namespace Fuz\GenyBundle\Services;

use Symfony\Component\Form\FormInterface;
use Fuz\GenyBundle\Entity\Form;

class Initializer
{

    public function initialize(FormInterface $type, Form $form, $scope = 0)
    {
        if (false === $form->getType()->isCompound()) {
            if (0 === $scope) {
                $type = $type->get($form->getName());
            }
            if (is_null($form->getData())) {
                return;
            }
            $type->setData($form->getData());
            return;
        }

        // todo: if there are data for a compound object, we also need to apply them first

        foreach ($form->getFields() as $field) {
            $child = $type->get($field->getName());
            $this->initialize($child, $field, $scope + 1);
        }
    }

}
