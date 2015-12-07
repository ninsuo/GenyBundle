<?php

namespace GenyBundle\Repository;

use GenyBundle\Base\BaseRepository;
use GenyBundle\Entity\Field;
use GenyBundle\Entity\Form;
use GenyBundle\Entity\Type;

/**
 * FieldRepository.
 */
class FieldRepository extends BaseRepository
{
    public function createField(Form $form, $typeName)
    {
        $field = new Field();
        $field->setPosition($form->getFields()->count() + 1);
        $field->setForm($form);
        $field->setName($this->get('translator')->trans('geny.builder.field.name', [], 'geny'));

        $builder = $this->get('geny.type')->getType($typeName);

        $type = new Type();
        $type->setField($field);
        $type->setName($typeName);
        $type->setData($builder->getDefaultData());
        $type->setOptions($builder->getDefaultOptions());
        $type->setConstraints($builder->getDefaultConstraints());

        $field->setType($type);
        $field->setLabel($this->get('translator')->trans('geny.builder.field.label', [], 'geny'));
        $field->setHint($this->get('translator')->trans('geny.builder.field.hint', [], 'geny'));
        $field->setRequired(true);

        $form->getFields()->add($field);

        $this->_em->persist($form);
        $this->_em->flush($form);
    }
}
