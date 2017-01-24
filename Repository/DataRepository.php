<?php

namespace GenyBundle\Repository;

use Doctrine\ORM\Query;

/**
 * DataRepository
 */
class DataRepository extends \Doctrine\ORM\EntityRepository {

    public function dataField($id) {

        $data = $this->_em->getRepository('GenyBundle:Data')
                ->findOneById($id);

        $form = $data->getForm();

        $data_data = $data->getData();

        $data_field = array();
        $i = 0;
        while (list($key, $value) = each($data_data)) {
            $field = $this->_em->getRepository('GenyBundle:Field')->findOneBy(array('name' => $key, 'form' => $form));
            $label = $field->getLabel();
            $data_field[$i]['value'] = $value;
            $data_field[$i]['field_name'] = $value;
            $data_field[$i]['field_label'] = $label;
            $i++;
        }

        return $data_field;
    }

    public function dataSet($set_id) {

        $results = $this->_em->createQuery('SELECT IDENTITY(d.field_id), IDENTITY(d.data_text_id) as data_text_id, f.name, f.label, dt.text FROM GenyBundle:Data d LEFT JOIN d.field_id f LEFT JOIN d.data_text_id dt WHERE d.set_id = :set_id')
                ->setParameter('set_id', $set_id)
                ->getResult();


        return $results;
    }

}
