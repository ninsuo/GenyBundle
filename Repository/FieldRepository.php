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
    public function createField(Form $form, $typeName)
    {
        $builder = $this->get('geny.builder')->getBuilder($typeName);

        $field = new Field();
        $field->setPosition($form->getFields()->count() + 1);
        $field->setForm($form);
        $field->setName($this->get('translator')->trans('geny.builder.field.name', [], 'geny'));
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
}
