<?php

namespace GenyBundle\Repository;

use GenyBundle\Base\BaseRepository;
use GenyBundle\Entity\Field;
use GenyBundle\Entity\Form;

/**
 * FieldRepository.
 */
class FieldRepository extends BaseRepository
{
    protected $fields = [];

    public function createField(Form $form, $typeName)
    {
        $builder = $this->get('geny.builder')->getBuilder($typeName);

        $field = new Field();
        $field->setPosition($form->getFields()->count() + 1);
        $field->setForm($form);
        $field->setName(sprintf("%s_%d", $this->get('translator')->trans('geny.builder.field.name', [], 'geny'), $field->getPosition()));
        $field->setType($typeName);
        $field->setData($builder->getDefaultData());
        $field->setOptions($builder->getDefaultOptions());
        $field->setConstraints($builder->getDefaultConstraints());
        $field->setLabel($this->get('translator')->trans('geny.builder.field.label', [], 'geny'));
        $field->setHelp($this->get('translator')->trans('geny.builder.field.help', [], 'geny'));
        $field->setRequired(true);

        $form->getFields()->add($field);

        $this->_em->persist($form);
        $this->_em->flush($form);
    }

    public function retrieveField($id)
    {
        if (array_key_exists($id, $this->fields)) {
            $entity = $this->fields[$id];
        } else {
            $entity = $this->find($id);
            if (!is_null($entity)) {
                $this->fields[$id] = $entity;
            }
        }

        return $entity;
    }
}
