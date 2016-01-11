<?php

namespace GenyBundle\Repository;

use GenyBundle\Base\BaseRepository;
use GenyBundle\Entity\Form;

/**
 * FormRepository.
 */
class FormRepository extends BaseRepository
{
    protected $forms = [];

    public function retrieveForm($id, $cached = true)
    {
        if ($cached && array_key_exists($id, $this->forms)) {
            $entity = $this->forms[$id];
        } else {
            $entity = $this->findOneById($id);
            if (!is_null($entity)) {
                $this->forms[$id] = $entity;
            }
        }

        return $entity;
    }

    public function saveForm(Form $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        $this->forms[$entity->getId()] = $entity;

        return $this;
    }
}
