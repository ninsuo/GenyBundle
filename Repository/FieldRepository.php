<?php

namespace GenyBundle\Repository;

use GenyBundle\Base\BaseRepository;
use GenyBundle\Entity\Field;
use GenyBundle\Entity\Form;
use GenyBundle\Provider\Builder\BuilderInterface;

/**
 * FieldRepository.
 */
class FieldRepository extends BaseRepository
{
    protected $fields = [];

    public function createField(Form $form, $typeName)
    {
        $builder = $this->get('geny.builder')->getBuilder($typeName);
        $field = $this->createFilledField($builder, $form);

        $form->getFields()->add($field);

        $this->_em->persist($form);
        $this->_em->flush($form);
    }

    public function createFilledField(BuilderInterface $builder, Form $form = null, $name = null)
    {
        $field = new Field();

        if ($form) {
            $field->setPosition($form->getFields()->count() + 1);
            $field->setForm($form);
            $field->setName(sprintf('%s_%d', $this->get('translator')->trans('geny.builder.field.name', [], 'geny'), $field->getPosition()));
        }

        if ($name) {
            $field->setName($name);
        }

        $field->setType($builder->getName());
        $field->setData($builder->getDefaultData($field));
        $field->setOptions(null);
        $field->setConstraints(null);
        $field->setLabel($this->get('translator')->trans('geny.builder.field.label', [], 'geny'));
        $field->setHelp($this->get('translator')->trans('geny.builder.field.help', [], 'geny'));
        $field->setRequired(true);

        return $field;
    }

    public function retrieveField($id, $cached = true)
    {
        if ($cached && array_key_exists($id, $this->fields)) {
            $entity = $this->fields[$id];
        } else {
            $entity = $this->findOneById($id);
            if (!is_null($entity)) {
                $this->fields[$id] = $entity;
            }
        }

        return $entity;
    }

    public function saveField(Field $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        $this->fields[$entity->getId()] = $entity;

        return $this;
    }

    public function moveTo(Form $form, Field $field, $position)
    {
        $array = $form->getFields()->toArray();
        usort($array, function ($a, $b) {
            return $a->getPosition() > $b->getPosition() ? 1 : -1;
        });

        $oldIndex = array_search($field, $array, true);
        if (false === $oldIndex) {
            return 0;
        }

        if ($array[$oldIndex]->getPosition() === $position) {
            return 0;
        }

        if ($position < 1) {
            $position = 1;
        } elseif ($position > $count = count($array)) {
            $position = $count;
        }

        $newIndex = $position - 1;

        $changes = 0;
        if ($oldIndex < $newIndex) {
            for ($i = $oldIndex + 1; $i <= $newIndex; ++$i) {
                $array[$i]->setPosition($i);
                ++$changes;
                $this->_em->persist($array[$i]);
            }
        } else {
            for ($i = $oldIndex - 1; $i >= $newIndex; --$i) {
                $array[$i]->setPosition($i + 2);
                ++$changes;
                $this->_em->persist($array[$i]);
            }
        }

        $field->setPosition($position);
        $this->_em->persist($field);

        $this->_em->flush();

        foreach ($array as $element) {
            $form->getFields()->set($element->getPosition() - 1, $element);
        }

        return $changes;
    }
}
