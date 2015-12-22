<?php

namespace GenyBundle\Services;

use GenyBundle\Base\BaseService;
use GenyBundle\Exception\FormNotFoundException;
use GenyBundle\Exception\FieldNotFoundException;
use GenyBundle\Entity\Form;
use GenyBundle\Entity\Field;
use GenyBundle\Traits\FormTrait;
use Symfony\Component\Form\Extension\Core\Type;

class Geny extends BaseService
{
    use FormTrait;

    public function getFormEntity($id)
    {
        $entity = $this->get('geny.repository.form')->retrieveForm($id);

        if (is_null($entity)) {
            throw new FormNotFoundException($id);
        }

        return $entity;
    }

    public function getForm($id)
    {
        if ($id instanceof Form) {
            $entity = $id;
            $id     = $entity->getId();
        } else {
            $entity = $this->getFormEntity($id);
        }

        $form = $this->getBuilder(sprintf("form-%d", $id), Type\FormType::class, [], null);
        foreach ($entity->getFields() as $field) {
            $form->add($this->getField($field));
        }
        $form->add($this->getBuilder(sprintf("submit", $id), Type\SubmitType::class, ['label' => $entity->getSubmit()]));

        return $form->getForm();
    }

    public function getFieldEntity($id)
    {
        $entity = $this->get('geny.repository.field')->retrieveField($id);

        if (is_null($entity)) {
            throw new FieldNotFoundException($id);
        }

        return $entity;
    }

    public function getField($id)
    {
        if ($id instanceof Field) {
            $entity = $id;
            $id     = $entity->getId();
        } else {
            $entity = $this->getFieldEntity($id);
        }

        $builder = $this->get('geny.builder')->getbuilder($entity->getType());
        return $builder->getDataType($entity);
    }
}
