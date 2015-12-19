<?php

namespace GenyBundle\Services;

use GenyBundle\Base\BaseService;
use GenyBundle\Exception\FormNotFoundException;
use GenyBundle\Exception\FieldNotFoundException;
use GenyBundle\Entity\Form;
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
            $builder                = $this->get('geny.builder')->getbuilder($field->getType());
            $data                   = $builder->normalizeData($field->getData());
            $options                = $builder->normalizeOptions($field->getOptions());
            $options['constraints'] = $builder->normalizeConstraints($field->getConstraints());
            $form->add($builder->getDataType($field->getName(), $options, $data));
        }
        $form->add($this->getBuilder(sprintf("submit", $id), Type\SubmitType::class, ['label' => $entity->getSubmit()]));

        return $form->getForm();
    }

    public function getFieldEntity($id)
    {
        $entity = $this->get('geny.repository.field')->retrieveField($formId, $fieldId);

        if (is_null($entity)) {
            throw new FieldNotFoundException($id);
        }

        return $entity;
    }


}
