<?php

namespace GenyBundle\Repository;

use GenyBundle\Entity\Form;
use GenyBundle\Base\BaseRepository;

/**
 * FormRepository.
 */
class FormRepository extends BaseRepository
{
    protected $forms = array();

    public function retrieveForm($id)
    {
        if (array_key_exists($id, $this->forms)) {
            $entity = $this->forms[$id];
        } else {
            $entity = $this->find($id);

            if (!is_null($entity)) {
                $this->forms[$id] = $entity;
            }
        }

        return $entity;
    }

    public function saveForm(Form $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush($entity);

        $this->forms[$entity->getId()] = $entity;

        return $this;
    }
}
