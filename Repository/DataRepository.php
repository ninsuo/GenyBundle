<?php

namespace GenyBundle\Repository;

use Doctrine\ORM\Query;

/**
 * DataRepository
 */
class DataRepository extends \Doctrine\ORM\EntityRepository {

    public function dataSet($set_id) {
 
        $results = $this->_em->createQuery('SELECT IDENTITY(d.field_id), f.label, dt.text FROM GenyBundle:Data d LEFT JOIN d.field_id f LEFT JOIN d.data_text_id dt WHERE d.set_id = :set_id')
                ->setParameter('set_id', $set_id)
                ->getResult();


        return $results;
    }
    
    public function dataSetList($form_id){
        
                $results = $this->_em->createQuery('SELECT d FROM GenyBundle:Data d LEFT JOIN d.field_id f LEFT JOIN f.form form WHERE form.id = :id GROUP BY d.set_id')
                ->setParameter('id', $form_id)
                ->getResult();


        return $results;
        
    }

}
