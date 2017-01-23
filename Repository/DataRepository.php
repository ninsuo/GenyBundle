<?php

namespace GenyBundle\Repository;

use Doctrine\ORM\Query;

/**
 * DataRepository
 */
class DataRepository extends \Doctrine\ORM\EntityRepository {

    public function dataSet($set_id) {
 
        $results = $this->_em->createQuery('SELECT IDENTITY(d.field_id), IDENTITY(d.data_text_id) as data_text_id, f.name, f.label, dt.text FROM GenyBundle:Data d LEFT JOIN d.field_id f LEFT JOIN d.data_text_id dt WHERE d.set_id = :set_id')
                ->setParameter('set_id', $set_id)
                ->getResult();


        return $results;
    }
    
}
